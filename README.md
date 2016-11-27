data-processor
==============
A lib providing interfaces and tools for "processing" data which, for our case,
means to iterate data, run rules against each, and output somewhere if the
rules are true.

You can use expressions from
[symfomy/expression-language](http://symfony.com/doc/current/components/expression_language.html)
which provides a convenient way to filter your data.

At the moment, only csv files are supported for input. 

# Install
`composer require johnpancoast/data-processor:~0.1`

# Usage
*All examples here can be seen in `docs/example/`.*

The first things you should do when using data-processor is to create your CLI
command that loads this lib's commands. You only need to do this once.

`bin/your-cli-command`
```php
#!/usr/bin/env php
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Pancoast\DataProcessor\ConsoleHelper;

ConsoleHelper::createAndLoad()->run();

```

Now let's imagine the following csv at `./animals.csv`.
```
id, title, sound
1,dog,bark
2,cat,meow
3,lion,meow
4,dinosaur,rawr
```

You first need to define a class that represents an iteration of this data. 
```php
<?php

namespace YourNamespace;

class Animal
{
    public $id;
    public $title;
    public $sound;
}

```

Note that the properties are public. They don't have to be but this provides flexibility later.

Now let's add `jms/serializer` [annotations](http://jmsyst.com/libs/serializer/master/reference/annotations) so the data can be (de)serialized and validated.

```php
<?php

namespace YourNamespace;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 */
class Animal
{
    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Type("int")
     */
    public $id;

    /**
     * @var string
     * 
     * @JMS\Expose
     * @JMS\Type("string")
     */
    public $title;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    public $sound;
}

```

We can now use your CLI command to filter data using expressions.

#### Show animals with id greater than 1 (see `--expr` option)
```sh
./bin/your-cli-command csv \
--file="./animals.csv" \
--data-class="YourNamespace\\Animal" \
--expr-root="pet" \
--expr="pet.id > 1"
```

#### Show pets having title with length greater than 3 and which meow
```sh
./bin/your-cli-command csv \
--file="./animals.csv" \
--data-class="YourNamespace\\Animal" \
--expr-root="pet" \
--expr="len(pet.title) > 3 && pet.sound == 'meow'"
```

#### Use a config file. Configs are yaml files and can contain any of the command options. CLI options override those in configs.
```sh
# assume config file at config.yaml
$ cat config.yaml
file="./animals.csv"'
data-class="YourNamespace\\Animal"
expr-root="pet"

./bin/your-cli-command csv -c "config.yaml" -e "len(pet.title) && pet.sound == 'meow'"
```

#### You can provide an output for an expression which will direct iteration there instead of STDOUT when expression is true. 
```sh
# assume config file at config.yaml
$ cat config.yaml
file="./animals.csv"'
data-class="YourNamespace\\Animal"
expr-root="pet"

./bin/your-cli-command csv -c "config.yaml" -o ./output-expr1.csv -e "len(pet.title) && pet.sound == 'meow'"
```

Both `--expr` and `--out` are arrays and each are run independently of the
other. Meaning, you can create any number of expression and output pairings
that each run on their own.

# TODO
* Tests
* A new `--group` array option for each `--expr` so that output can be grouped.
* More commands to input more formats (internally, all formats that the serializer supports are supported... it's just our command that doesn't support more yet).
