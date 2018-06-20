<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class IdConverter implements Resource
{
    /**
     * @var string
     */
    protected $url = 'https://www.ncbi.nlm.nih.gov/pmc/utils/idconv/v1.0/';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'query' => [
            'format' => 'json',
            'tool' => 'pubpeer',
            'email' => 'contact@pubpeer.com',
            'version' => 'no',
            'ids' => '',
        ],
    ];

    /**
     * IdConverter constructor.
     * @param Identifier $identifier
     */
    public function __construct(Identifier $identifier)
    {
        $this->queryStringParameters['query']['ids'] = $identifier->getQueryString();
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        return $this->queryStringParameters;
    }

    /**
     * @param  string $document
     * @return array
     */
    public function getDataFrom(string $document): array
    {
        try {
            $baseTree = json_decode($document, true);
            $extractor = new Extractors\IdConverter($baseTree);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
