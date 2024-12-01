<?php // config/schemas/blog.php

use Schranz\Search\SEAL\Schema\Field;
use Schranz\Search\SEAL\Schema\Index;

return new Index('product', [
    'id' => new Field\IdentifierField('id'),
    'name' => new Field\TextField('name'),
    'imageUrl' => new Field\TextField('imageUrl', filterable: false, searchable: false),
    'price' => new Field\IntegerField('price', sortable: true, searchable: false),

    'description' => new Field\TextField('description'),
    'colors' => new Field\TextField('colors', multiple: true, filterable: true),
]);
