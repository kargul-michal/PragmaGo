<?php
namespace App\Component;

use App\Exception\TypeException;

/**
 * lista elementow indeksowana po category_id
 *
 *
 * @author MicKar
 *        
 */
class ListMap
{

    const PLACEHOLDER = 'Noname';

    protected $translation = 'pl_PL';

    protected $map = [];

    public function __construct(array $listData) {
        $this->create($listData);
    }

    /**
     * tworzy mape category_id => obiekt listy
     *
     * @param array $listData
     * @throws TypeException
     * @return self
     */
    public function create(array $listData): self {
        foreach ($listData as $listElement) {

            if (! ($listElement instanceof \stdClass)) {
                throw new TypeException("Oczekiwano obiekty typy: stdClass");
            }
            $this->map[$listElement->category_id] = $listElement;
        }

        return $this;
    }

    /**
     * zwraca nazwe kateegori na podstawie podanego id
     *
     * @param int $id
     *            category_id z listy kategorii
     * @return string nazwa lub {self::PLACEHOLDER}
     */
    public function getNameById(int $id): string {
        if (! isset($this->map[$id])) {
            return self::PLACEHOLDER;
        }

        $listElement = $this->map[$id];

        if (property_exists($listElement, 'translations') && property_exists($listElement->translations, $this->translation)) {
            return $listElement->translations->{$this->translation}->name;
        }

        return self::PLACEHOLDER;
    }

    /**
     *
     * @return string
     */
    public function getTranslation() {
        return $this->translation;
    }

    /**
     *
     * @param string $translation
     */
    public function setTranslation($translation) {
        $this->translation = $translation;

        return $this;
    }
}