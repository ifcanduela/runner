<?php

namespace app\controllers;

use app\services\Runner;

const DEFAULT_CODE = <<<CODE
<?php

require_once __DIR__ . "/../vendor/autoload.php";

CODE;

class AppController extends \pew\Controller
{
    public function index()
    {
        $this->view->template("index");

        $code = DEFAULT_CODE;
        $output = null;
        
        if ($this->request->post()) {
            $code = $this->request->post($code);
            $runner = new Runner();
            $output = $runner->run($code);
        }

        $snippets = array_map(function ($f) {
            $snippet = json_decode(file_get_contents($f));
            $snippet->name = basename($f);

            return $snippet;
        }, glob(root("data/*")));

        return [
            'code' => $code,
            'output' => $output,
            'snippets' => $snippets,
            'json' => $this->getComposerPackages(),
        ];
    }

    /**
     * Run a piece of code.
     */
    public function run()
    {
        $code = $this->request->post("code");
        $runner = new Runner();
        $output = $runner->run($code);

        $this->view->template("output");
        $this->view->layout(false);

        return [
            "output" => $output,
        ];
    }

    /**
     * Install a Composer package.
     */
    public function install()
    {
        $package = $this->request->post("packageName");
        chdir(root());
        $output = `composer require $package`;

        $this->view->template("packages");
        $this->view->layout(false);

        return [
            "packages" => $this->getComposerPackages()->packages,
        ];
    }

    public function uninstall()
    {
        $package = $this->request->post("packageName");
        chdir(root());
        $output = `composer remove $package`;

        $this->view->template("packages");
        $this->view->layout(false);

        return [
            "packages" => $this->getComposerPackages()->packages,
        ];
    }

    /**
     * Write a snippet file.
     */
    public function save()
    {
        $title = $this->request->post("title");
        $code = $this->request->post("code");
        $name = (string) \Stringy\Stringy::create($title)->slugify();
        $snippet = compact("title", "code");
        $json = json_encode($snippet);

        $filename = root("data", $name);
        $is_new = !file_exists($filename);
        file_put_contents(root("data", $name), $json);

        return $this->renderJson(compact("name", "title", "is_new"));
    }

    /**
     * Read a snippet file.
     */
    public function load($name)
    {
        $json = file_get_contents(root("data", $name));
        $snippet = json_decode($json);

        return $this->renderJson($snippet);
    }

    /**
     * Delete a snippet file.
     */
    public function delete()
    {
        $name = $this->request->post("name");
        $filename = root("data", $name);

        if ($exists = file_exists($filename)) {
            unlink($filename);
        }

        return $this->renderJson($exists);
    }

    /**
     * Get a list of Composer packages currently available.
     * 
     * @return array
     */
    private function getComposerPackages()
    {
        $composer_lock = root("composer.lock");
        return json_decode(file_get_contents($composer_lock));
    }
}
