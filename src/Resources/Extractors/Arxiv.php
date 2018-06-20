<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

class Arxiv extends Extractor implements ProvidesPublicationData, ProvidesIdentifiersData, ProvidesAuthorsData, ProvidesJournalData, ProvidesTypesData
{
    /**
     * Create search tree.
     */
    protected function getDataFromDocument()
    {
        $this->searchTree = $this->document->entry;
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData()
    {
        $this->output['publication'] = [
            'title' => get_string($this->searchTree, 'title'),
            'abstract' => get_string($this->searchTree, 'summary'),
            'url' => get_string($this->searchTree, 'id'),
            'published_at' => date_from_parseable_format(get_string($this->searchTree, 'published')),
        ];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData()
    {
        $this->output['identifiers'][] = [
            'value' => (string) $this->getIdentifier(),
            'type' => 'arxiv',
        ];

        $this->output['identifiers'][] = [
            'value' => '2331-8422',
            'type' => 'issn',
        ];
    }

    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalData()
    {
        $this->output['journal'] = [
            'title' => 'arXiv',
            'issn' => ['2331-8422'],
        ];
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData()
    {
        foreach (get_array($this->searchTree, 'author') as $author) {
            $name = explode(' ', $author->name, 2);
            $this->output['authors'][] = [
                'first_name' => $name[0] ?? null,
                'last_name' => $name[1] ?? null,
            ];
        }
    }

    /**
     * Extract and format data needed for the Types Relationship
     * on the Publication Model.
     */
    public function extractTypesData()
    {
        $this->output['types'][] = [
            'name' => 'arxiv',
        ];
    }

    /**
     * @return mixed
     */
    protected function getIdentifier()
    {
        $urlParts = explode('/', $this->searchTree->id[0]);

        return array_pop($urlParts);
    }
}
