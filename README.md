iterable-search
===============
A lib providing interfaces and tools for searching through iterations of
tabular data.

**This was created as a code challenge and also to explore ideas for some tools I was thinking of**.

_This was created for a code challenge and to explore ideas for some tools
I was thinking of. It became useful a few times but it is incomplete and at
version <= 1, so APIs may still change._

## Ideas for future improvement (also see [TODO](#todo)).
* Simpler CLI API around the APIs here (with possible simplifications).
* Create a command so it's not required of the
  user of this lib to create.

Once you've set things up (which is quick), you can use expressions from
[symfomy/expression-language](http://symfony.com/doc/current/components/expression_language.html)
via CLI.

At the moment only csv files are supported for input but it's easy enough to
add handlers.

# Install
`composer require johnpancoast/iterable-parser:~0`

# Usage
*All examples here can be seen in `docs/example/`.*

The first things you should do when using data-processor is to create your CLI
command that loads this lib's commands. You only need to do this once. **This is
meant to be improved upon so you don't have to create a command and can just
include one from the lib.**

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

Now let's add `jms/serializer`
[annotations](http://jmsyst.com/libs/serializer/master/reference/annotations)
so the data can be (de)serialized and validated.

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
* Simpler CLI API around the APIs here (possible simplifications).
* Create a command so the user (you) doesn't have to.
* Tests
* A new `--group` array option for each `--expr` so that output can be grouped.
* More commands to input more formats (internally, all formats that the serializer supports are supported... it's just our command that doesn't support more yet).
