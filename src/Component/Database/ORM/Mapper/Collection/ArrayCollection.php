<?php
namespace Laventure\Component\Database\ORM\Mapper\Collection;

use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;

class ArrayCollection implements \ArrayAccess, \Countable
{


      /**
       * @var array
      */
      protected $items = [];



      /**
       * @param object $object
       * @return $this
      */
      public function add(object $object): static
      {
          $this->items[] = $object;

          return $this;
      }




      /**
       * @param object $object
       * @return bool
      */
      public function contains(object $object): bool
      {
           return in_array($object, $this->items);
      }



      /**
       * @inheritDoc
      */
      public function count(): int
      {
         return count($this->items);
      }


      /**
       * @param $object
       * @return false|int|string
      */
      public function key($object)
      {
           return array_search($object, $this->items);
      }




      /**
       * @param object $object
       * @return void
      */
      public function remove(object $object): void
      {
           $key = array_search($object, $this->items);

           unset($this->items[$key]);
      }




      /**
       * @return array
      */
      public function toArray(): array
      {
          return $this->items;
      }




      /**
       * @return bool
      */
      public function isEmpty(): bool
      {
           return empty($this->items);
      }




      /**
       * @inheritDoc
     */
     public function offsetExists(mixed $offset): bool
     {
         return $this->contains($offset);
     }




     /**
      * @inheritDoc
     */
     public function offsetGet(mixed $offset): mixed
     {
         return $this->items[$offset] ?? null;
     }




     /**
      * @inheritDoc
     */
     public function offsetSet(mixed $offset, mixed $value): void
     {
          $this->add($value);
     }




    /**
     * @inheritDoc
    */
    public function offsetUnset(mixed $offset): void
    {
         $this->remove($offset);
    }
}