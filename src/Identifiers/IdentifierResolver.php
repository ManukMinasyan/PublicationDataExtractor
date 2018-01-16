<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnknownIdentifierException;

class IdentifierResolver
{
    /**
     * List of available Identifiers.
     *
     * @var array
     */
    protected $identifiers = [
        BioArxiv::class,
        Figshare::class,
        Doi::class,
        Arxiv::class,
        Pubmed::class,
    ];

    /**
     * The query string.
     *
     * @var string
     */
    private $queryString;

    /**
     * Identifier constructor.
     *
     * @param string $queryString
     */
    public function __construct(string $queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * Resolves the Identifier;.
     *
     * @return Identifier
     *
     * @throws UnknownIdentifierException
     */
    public function handle()
    {
        foreach ($this->identifiers as $identifierClass) {
            $identifier = new $identifierClass($this->queryString);

            if ($identifier->isValid()) {
                return $this->validIdentifier = $identifier;
            }
        }

        throw new UnknownIdentifierException();
    }

}