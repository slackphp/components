<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

/**
 * A file block
 * @package SIF\Components\Blocks
 */
class File extends Block {

    protected string $type = 'file';

    /**
     * @var string The unique external ID for the file
     */
    public string $externalId;

    /**
     * @var string Source of file (at this time it is always remote)
     */
    public string $source = self::SOURCE_REMOTE;

    public const SOURCE_REMOTE = 'remote';

    /**
     * @param string $externalId
     * @param string $source
     * @param string|null $id
     * @throws \SIF\Components\Exceptions\ValueTooLargeException
     */
    public function __construct(string $externalId, string $source = self::SOURCE_REMOTE, ?string $id = null) {
        parent::__construct($id);

        $this->externalId = $externalId;
        $this->source = $source;
    }

    public function jsonSerialize() {
        return [
            'external_id'   =>  $this->externalId,
            'source'    =>  $this->source,
        ] + parent::jsonSerialize();
    }

}