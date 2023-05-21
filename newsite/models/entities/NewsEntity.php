<?php
namespace Newsite\Models\Entities;

use DateTime;

class NewsEntity extends Entity
{
	public string $id = '';
	public string $title = '';
	public string $idate = '';
	public string $announce = '';
	public string $content = '';

	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId(string $id): void
	{
		$this->id = $id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

    public function getIdate(): string
    {
        $date = DateTime::createFromFormat('U', $this->idate);

        return $date->format('d.m.Y');
    }

    /**
     * @param string $idate
     */
    public function setIdate(string $idate): void
    {
        $date = DateTime::createFromFormat('U', $idate);

        $this->idate = $date->format('d.m.Y');
    }

    public function getAnnounce(): string
    {
        return $this->announce;
    }

    /**
     * @param string $announce
     */
    public function setAnnounce(string $announce): void
    {
        $this->announce = $announce;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }





}