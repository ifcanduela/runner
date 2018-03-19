<?php
$this->layout(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Runner</title>
    <link rel="stylesheet" href="<?= url("css/app.css") ?>">
</head>

<body>
    <div id="input" class="panel">
        <div class="header">
            <div class="logo"><span>R</span>Runner</div>
            <menu>
                <div class="main-menu-item">
                    <a href="#">Snippets</a>
                    <div class="dropdown">
                        <a href="#" class="menu-btn" id="save-snippet">Save snippet...</a>
                        <div id="load-snippet">
                            <?php foreach ($snippets as $snippet): ?>
                                <div class="snippet">
                                    <a href="#" class="load" data-name="<?= $snippet->name ?>"><?= $snippet->title ?></a>
                                    <a href="#" class="delete" data-name="<?= $snippet->name ?>">&times;</a>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <div class="main-menu-item">
                    <a href="#">Packages</a>
                    <div class="dropdown">
                        <a href="#install" class="menu-btn" id="install">Install package...</a>

                        <div id="package-list">
                            <?= $this->insert("packages", ["packages" => $packages]) ?>
                        </div>
                    </div>
                </div>
            </menu>
        </div>

        <div class="help">Press Ctrl+Enter to run the code</div>

        <div class="code" id="ace-wrapper"></div>

        <textarea name="code" id="initial-code"><?= $code ?></textarea>
    </div>

    <div id="output" class="panel">
        <?= $this->insert("output", ["output" => $output]) ?>
    </div>

    <div id="overlay" class="hidden">
        <div id="loading"></div>
    </div>

    <script src="<?= url("ace/ace.js") ?>"></script>
    <script src="<?= url("ace/ext-language_tools.js") ?>"></script>

    <script src="<?= url("js/app.bundle.js") ?>"></script>
</body>
</html>
