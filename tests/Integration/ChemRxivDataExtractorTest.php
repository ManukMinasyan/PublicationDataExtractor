<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\ChemRxiv;

class ChemRxivDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_journal_data_from_figshare_api()
    {
        // Arrange
        $file = $this->loadJson('ChemRxiv/valid-article');

        // Act
        $extracted = (new ChemRxiv($file))->extract();

        // Assert
        $this->assertArraySubset([
            'title' => 'ChemRxiv',
        ], $extracted['journal']);

        $this->assertArrayIsValid($extracted);
    }
}
