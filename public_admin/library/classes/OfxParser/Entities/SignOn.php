<?php



namespace OfxParser\Entities;

require_once 'library/classes/OfxParser/Entities/AbstractEntity.php';

class SignOn extends AbstractEntity
{
    /**
     * @var Status
     */
    public $status;

    /**
     * @var \DateTimeInterface
     */
    public $date;

    /**
     * @var string
     */
    public $language;

    /**
     * @var Institute
     */
    public $institute;
}
