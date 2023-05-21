<?php

namespace Newsite\Database;

use mysqli;
use Newsite\Logger;

class Database
{

	public const RESULT_ASSOC = MYSQLI_ASSOC;
	private mysqli $connection;

	public static array $config = [
		'host' => 'localhost',
		'userName' => 'root',
		'password' => 'root',
		'dbName' => 'newssite',
	];

	public function __construct()
	{
		$this->openConnection();
	}

	public static function setConfig(array $config): void
	{
		self::$config = $config;
	}

	public function lastInsertId(): int
	{
		return $this->connection->insert_id;
	}

	public function openConnection(): bool
	{
		$this->connection = new mysqli(self::$config['host'], self::$config['userName'], self::$config['password'], self::$config['dbName']);
		if ($this->connection->connect_error)
		{
			die('Connect Error (' . $this->connection->connect_errno . ') ' . $this->connection->connect_error);
		}

		return true;
	}

	public function closeConnection()
	{
		$this->connection->close();
	}

	/**
	 * Функция выполнения запроса.
	 * Пример:
	 * $db->query("DELETE FROM table WHERE id=?i", $id);
	 *
	 * @param string $query - SQL запрос с плейсхолдерами
	 * @param mixed $arg,... аргументы для замены плейсхолдеров запроса
	 *
	 * @return resource|FALSE
	 */
	public function query(string $query, ...$arg)
	{
		return $this->rawQuery($this->prepareQuery(func_get_args()));
	}

	private function rawQuery($query)
	{
		$res = mysqli_query($this->connection, $query);
		if (!$res)
		{
			$error = mysqli_error($this->connection);
			$this->error($error);
		}

		return $res;
	}

	private function error($error): void
	{
		Logger\Logger::error($error);
	}

	private function prepareQuery($args)
	{
		$query = '';
		$raw = array_shift($args);
		$array = preg_split('~(\?[nsiuapb])~u', $raw, null, PREG_SPLIT_DELIM_CAPTURE);
		$argNum = count($args);
		$phNum = floor(count($array) / 2);
		if ($phNum != $argNum)
		{
			$this->error("Number of args ($argNum) doesn't match number of placeholders ($phNum) in [$raw]");
		}

		foreach ($array as $i => $part)
		{
			if (($i % 2) === 0)
			{
				$query .= $part;
				continue;
			}

			$value = array_shift($args);
			switch ($part)
			{
				case '?b':
					$part = $this->escapeBool($value);
					break;
				case '?n':
					$part = $this->escapeIdent($value);
					break;
				case '?s':
					$part = $this->escapeString($value);
					break;
				case '?i':
					$part = $this->escapeInt($value);
					break;
				case '?a':
					$part = $this->createIN($value);
					break;
				case '?u':
					$part = $this->createSET($value);
					break;
				case '?p':
					$part = $value;
					break;
			}
			$query .= $part;
		}

		return $query;
	}

	private function escapeBool($value)
	{
		if ($value === true || $value === 1)
		{
			return true;
		}
		elseif ($value === false || $value === 0)
		{
			return false;
		}
		else
		{
			$this->error("Value for IN (?b) placeholder should be boolean");

			return;
		}
	}

	private function escapeIdent($value)
	{
		if ($value)
		{
			return "`" . str_replace("`", "``", $value) . "`";
		}
		else
		{
			$this->error("Empty value for identifier (?n) placeholder");
		}
	}

	private function escapeString($value): string
	{
		if ($value === null)
		{
			return 'NULL';
		}

		return "'" . mysqli_real_escape_string($this->connection, $value) . "'";
	}

	private function escapeInt($value)
	{
		if ($value === null)
		{
			return 'NULL';
		}
		if (!is_numeric($value))
		{
			$this->error("Integer (?i) placeholder expects numeric value, " . gettype($value) . " given");

			return false;
		}
		if (is_float($value))
		{
			$value = number_format($value, 0, '.', ''); // may lose precision on big numbers
		}

		return $value;
	}

	private function createIN($data)
	{
		if (!is_array($data))
		{
			$this->error("Value for IN (?a) placeholder should be array");

			return;
		}
		if (!$data)
		{
			return 'NULL';
		}
		$query = $comma = '';
		foreach ($data as $value)
		{
			$query .= $comma . $this->escapeString($value);
			$comma = ",";
		}

		return $query;
	}

	private function createSET($data)
	{
		if (!is_array($data))
		{
			$this->error("SET (?u) placeholder expects array, " . gettype($data) . " given");

			return;
		}
		if (!$data)
		{
			$this->error("Empty array for SET (?u) placeholder");

			return;
		}
		$query = $comma = '';
		foreach ($data as $key => $value)
		{
			$query .= $comma . $this->escapeIdent($key) . '=' . $this->escapeString($value);
			$comma = ",";
		}

		return $query;
	}

	/**
	 * Функция для получения количества строк в результате.
	 *
	 * @param resource $result
	 *
	 * @return int
	 */
	public function numRows($result)
	{
		return mysqli_num_rows($result);
	}

	/**
	 * Функция для получения всех строк результата в виде массива
	 */
	public function getQuery(string $sql, ...$arg)
	{
		$ret = [];
		$query = $this->prepareQuery(func_get_args());
		if ($res = $this->rawQuery($query))
		{
			while ($row = $this->fetch($res))
			{
				$ret[] = $row;
			}
			$this->free($res);
		}

		return $ret;
	}

	/**
	 * Функция для разбиения результата в массив.
	 *
	 * @param resource $result
	 * @param int $mode
	 *
	 * @return array|FALSE
	 */
	public function fetch($result, int $mode = self::RESULT_ASSOC): array
	{
		return mysqli_fetch_array($result, $mode) ?? [];
	}

	/**
	 * Очистка результата
	 */
	private function free($result)
	{
		mysqli_free_result($result);
	}

}