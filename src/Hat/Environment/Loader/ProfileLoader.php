<?php
namespace Hat\Environment\Loader;

use Hat\Environment\Profile;
use Hat\Environment\Definition;

use Hat\Environment\Handler\Handler;

class ProfileLoader
{

    protected $definitionOptionPrefix = '@';

    protected $systemDefinitionPrefix = '@';

    /**
     * @var \Hat\Environment\Handler\Handler
     */
    protected $post_load_handler;

    public function __construct(Handler $post_load_handler)
    {
        $this->post_load_handler = $post_load_handler;
    }


    /**
     * @param \Hat\Environment\Profile $profile
     * @return \Hat\Environment\Profile
     * @throws LoaderException
     */
    public function load(Profile $profile)
    {
        echo "[load] " . $profile->getPath();
        echo "\n";

        $data = $this->read($profile->getPath());

        foreach ($data as $name => $value) {

            $definition = $this->createDefinition($name, $value);

            if ($this->isSystemDefinition($name)) {
                $profile->addSystemDefinition($definition);
            } else {
                $profile->addDefinition($definition);
            }
        }

        $this->post_load_handler->handle($profile);

        return $profile;
    }

    /**
     * @param $path
     * @return \Hat\Environment\Profile
     */
    public function loadByPath($path)
    {
        return $this->load(new Profile($path));
    }

    /**
     * @param \Hat\Environment\Profile $profile
     * @param $path
     * @return \Hat\Environment\Profile
     */
    public function loadForProfile(Profile $profile, $path)
    {
        return $this->loadByPath($profile->getFile($path));
    }

    public function loadDocForProfile(Profile $profile, $path)
    {
        $path = $profile->getFile($path);
        return file_get_contents($path);
    }


    /**
     * @param $name
     * @param $data
     * @return \Hat\Environment\Definition
     */
    protected function createDefinition($name, $data)
    {
        $definition = new Definition($name);

        if (is_array($data)) {
            $this->defineOptions($definition, $data);
            $this->defineProperties($definition, $data);
        } else {
            $definition->setValue($data);
        }

        return $definition;
    }

    protected function read($path)
    {
        // TODO add readers
        if (file_exists($path)) {
            return parse_ini_file($path, true);
        } else {
            throw new LoaderException('File is not found: ' . getcwd() . '/' . $path);
        }

        return array();

    }


    protected function isSystemDefinition($name)
    {
        return substr($name, 0, 1) == $this->systemDefinitionPrefix;
    }

    protected function isOption($name)
    {
        return substr($name, 0, 1) == $this->definitionOptionPrefix;
    }

    protected function extractOption($name)
    {
        return $this->isOption($name) ? substr($name, 1) : $name;
    }


    protected function defineOptions(Definition $definition, $definition_data)
    {

        foreach ($definition_data as $name => $value) {
            if ($this->isOption($name)) {
                $definition->getOptions()->set($this->extractOption($name), $value);
            }
        }

    }

    protected function defineProperties(Definition $definition, $definition_data)
    {
        foreach ($definition_data as $name => $value) {
            if (!$this->isOption($name)) {
                $definition->getProperties()->set($this->extractOption($name), $value);
            }
        }
    }


}
