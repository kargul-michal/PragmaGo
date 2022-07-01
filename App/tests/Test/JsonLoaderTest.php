<?php
namespace Test;

use App\Component\ListMap;
use App\Exception\TypeException;
use PHPUnit\Framework\TestCase;

/**
 * testy dla klasy ListMap
 *
 * @author MicKar
 *        
 */
class ListMapTest extends TestCase
{

    /**
     *
     * @test
     */
    public function incorrectObject(): void {
        $this->expectException(TypeException::class);

        $listData = [
            'test'
        ];
        new ListMap($listData);
    }

    /**
     *
     * @test
     */
    public function name(): void {
        $listData = [];
        $map = new ListMap($listData);
        $this->assertEquals(ListMap::PLACEHOLDER, $map->getNameById(1));

        $id = 15;

        $element = new \stdClass();
        $element->category_id = $id;
        $element->translations = new \stdClass();

        $listData = [
            $element
        ];
        $map = new ListMap($listData);

        $this->assertEquals(ListMap::PLACEHOLDER, $map->getNameById($id));

        $translationName = 'moja_tanslacja';
        $name = 'testowa nazwa';

        $element->translations->{$translationName} = new \stdClass();
        $element->translations->{$translationName}->name = $name;

        $map = new ListMap($listData);
        $map->setTranslation($translationName);

        $this->assertEquals($name, $map->getNameById($id));
    }
}