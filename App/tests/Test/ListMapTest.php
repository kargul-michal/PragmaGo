<?php
namespace Test;

use App\Exception\FileMissingException;
use App\Exception\FileReadException;
use App\Service\JsonLoader;
use PHPUnit\Framework\TestCase;
use App\Exception\FileWrongContentException;

/**
 * testy dla klasy JsonLoader
 *
 * @author MicKar
 *        
 */
class JsonLoaderTest extends TestCase
{

    /**
     *
     * @var \App\Service\JsonLoader
     */
    protected $loader;

    /**
     *
     * {@inheritdoc}
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp(): void {
        $this->loader = new JsonLoader();
    }

    /**
     *
     * @test
     */
    public function missingFile(): void {
        $this->expectException(FileMissingException::class);
        $this->loader->load('var/nothing');

        $this->assertEmpty([], 'Brak danych');
    }

    /**
     *
     * @test
     */
    public function emptyFile(): void {
        $this->expectException(FileReadException::class);
        $file = 'var/empty.json';
        file_put_contents($file, '');
        $this->loader->load($file);
    }

    /**
     *
     * @test
     */
    public function incorrectFile(): void {
        $this->expectException(FileWrongContentException::class);
        $file = 'var/incorrect.json';
        file_put_contents($file, 'to nie jest json');
        $this->loader->load($file);
    }

    /**
     *
     * @test
     */
    public function correctData(): void {
        $file = 'var/incorrect.json';

        // pusta tablica
        $content = [];
        file_put_contents($file, json_encode($content));
        $loadedData = $this->loader->load($file);
        $this->assertIsArray($loadedData);
        $this->assertEmpty($loadedData);

        $object = new \stdClass();
        $object->attribute = 'test';

        // obiekt w tablicy
        $content = [
            $object
        ];
        file_put_contents($file, json_encode($content));
        $loadedData = $this->loader->load($file);
        $this->assertCount(1, $loadedData);
        $this->assertInstanceOf(\stdClass::class, $loadedData[0]);
        $this->assertEquals($object->attribute, $loadedData[0]->attribute);
    }
}