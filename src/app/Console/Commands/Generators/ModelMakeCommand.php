<?php

namespace App\Console\Commands\Generators;

use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommandBase
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:new-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new  model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    protected function generate($name)
    {
        $this->generateModel($name);
        $this->addModelFactory($name);
        $this->generateUnitTest($name);
    }

    protected function generateModel($name)
    {
        $path = $this->getPath($name);
        if ($this->alreadyExists($path)) {
            $this->error($name.' already exists.');

            return false;
        }

        $this->makeDirectory($path);
        $className = $this->getClassName($name);
        $tableName = $this->getTableName($name);

        $stub = $this->files->get($this->getStub($name));
        $this->replaceTemplateVariable($stub, 'CLASS', $className);
        $this->replaceTemplateVariable($stub, 'TABLE', $tableName);

        $columns = $this->getFillableColumns($tableName);
        $fillables = count($columns) > 0 ? "'".implode("',".PHP_EOL."        '", $columns)."'," : '';
        $this->replaceTemplateVariable($stub, 'FILLABLES', $fillables);

        $api = count($columns) > 0 ? implode(','.PHP_EOL.'            ', array_map(function ($column) {
                return "'".$column."'".' => $this->'.$column;
            }, $columns)).',' : '';
        $this->replaceTemplateVariable($stub, 'API', $api);

        $columns = $this->getDateTimeColumns($tableName);
        $datetimes = count($columns) > 0 ? "'".implode("','", $columns)."'" : '';
        $this->replaceTemplateVariable($stub, 'DATETIMES', $datetimes);

        $hasSoftDelete = $this->hasSoftDeleteColumn($tableName);
        $this->replaceTemplateVariable($stub, 'SOFT_DELETE_CLASS_USE',
            $hasSoftDelete ? 'use Illuminate\Database\Eloquent\SoftDeletes;'.PHP_EOL : PHP_EOL);
        $this->replaceTemplateVariable($stub, 'SOFT_DELETE_USE', $hasSoftDelete ? 'use SoftDeletes;'.PHP_EOL : PHP_EOL);

        $this->files->put($path, $stub);

        return true;
    }

    protected function getPath($name)
    {
        $className = $this->getClassName($name);

        return $this->laravel['path'].'/Models/'.$className.'.php';
    }

    protected function getStub($name)
    {
        return __DIR__.'/stubs/model.stub';
    }

    protected function getTableName($name)
    {
        $options = $this->option();
        if (array_key_exists('name', $options)) {
            return $optionName = $this->option('name');
        }

        $className = $this->getClassName($name);

        $name = \StringHelper::pluralize(\StringHelper::camel2Snake($className));
        $columns = $this->getTableColumns($name);
        if (count($columns)) {
            return $name;
        }

        $name = \StringHelper::singularize(\StringHelper::camel2Snake($className));
        $columns = $this->getTableColumns($name);
        if (count($columns)) {
            return $name;
        }

        return \StringHelper::pluralize(\StringHelper::camel2Snake($className));
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Models';
    }

    /**
     * @param  string $className
     * @return \App\Models\Base
     */
    protected function getModel($className)
    {
        return $className;
    }

    protected function getFillableColumns($tableName)
    {
        $hasDoctrine = interface_exists('Doctrine\DBAL\Driver');
        if (!$hasDoctrine) {
            return [];
        }
        $ret = [];
        $schema = \DB::getDoctrineSchemaManager();
        $columns = $schema->listTableColumns($tableName);
        if ($columns) {
            foreach ($columns as $column) {
                if ($column->getAutoincrement()) {
                    continue;
                }
                $columnName = $column->getName();
                if (!in_array($columnName, ['created_at', 'updated_at', 'deleted_at'])) {
                    $ret[] = $columnName;
                }
            }
        }

        return $ret;
    }

    protected function getDateTimeColumns($tableName)
    {
        $hasDoctrine = interface_exists('Doctrine\DBAL\Driver');
        if (!$hasDoctrine) {
            return [];
        }
        $ret = [];
        $schema = \DB::getDoctrineSchemaManager();
        $columns = $schema->listTableColumns($tableName);
        if ($columns) {
            foreach ($columns as $column) {
                if ($column->getType() != 'DateTime') {
                    continue;
                }
                $columnName = $column->getName();
                if (!in_array($columnName, ['created_at', 'updated_at'])) {
                    $ret[] = $columnName;
                }
            }
        }

        return $ret;
    }

    protected function hasSoftDeleteColumn($tableName)
    {
        $columns = $this->getTableColumns($tableName);
        if ($columns) {
            foreach ($columns as $column) {
                $columnName = $column->getName();
                if (in_array($columnName, ['deleted_at'])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $tableName
     * @return \Doctrine\DBAL\Schema\Column[]
     */
    protected function getTableColumns($tableName)
    {
        $hasDoctrine = interface_exists('Doctrine\DBAL\Driver');
        if (!$hasDoctrine) {
            return [];
        }
        $schema = \DB::getDoctrineSchemaManager();

        $ret = [];
        $columns = $schema->listTableColumns($tableName);
        foreach ($columns as $column) {
            if (!in_array($column->getName(), ['created_at', 'updated_at', 'deleted_at'])) {
                $ret[] = $column;
            }
        }

        return $ret;
    }

    protected function addModelFactory($name)
    {
        $className = $this->getClassName($name);
        $tableName = $this->getTableName($name);

        $columns = $this->getTableColumns($tableName);

        $factory = $this->files->get($this->getFactoryPath());
        $key = '/* NEW MODEL FACTORY */';

        $data = '$factory->define(App\Models\\'.$className.'::class, function (Faker\Generator $faker) {'.PHP_EOL.'    return ['.PHP_EOL;
        foreach ($columns as $column) {
            $data .= "        '".$column->getName()."' => '',".PHP_EOL;
        }
        $data .= '    ];'.PHP_EOL.'});'.PHP_EOL.PHP_EOL.$key;

        $factory = str_replace($key, $data, $factory);
        $this->files->put($this->getFactoryPath(), $factory);

        return true;
    }

    protected function getFactoryPath()
    {
        return $this->laravel['path'].'/../database/factories/ModelFactory.php';
    }

    protected function generateUnitTest($name)
    {
        $className = $this->getClassName($name);

        $path = $this->getUnitTestPath($name);
        if ($this->alreadyExists($path)) {
            $this->error($path.' already exists.');

            return false;
        }

        $this->makeDirectory($path);

        $stub = $this->files->get($this->getStubForUnitTest());

        $this->replaceTemplateVariable($stub, 'CLASS', $className);
        $this->replaceTemplateVariable($stub, 'class', strtolower(substr($className, 0, 1)).substr($className, 1));

        $this->files->put($path, $stub);

        return true;
    }

    /**
     * @param  string $name
     * @return string
     */
    protected function getUnitTestPath($name)
    {
        $className = $this->getClassName($name);

        return $this->laravel['path'].'/../tests/Models/'.$className.'Test.php';
    }

    /**
     * @return string
     */
    protected function getStubForUnitTest()
    {
        return __DIR__.'/stubs/model-unittest.stub';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['table', '-t', InputOption::VALUE_OPTIONAL, 'Table Name', null],
        ];
    }
}
