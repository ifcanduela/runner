<?php if (isset($output)): ?>
    <?php $padding_length = min(strlen(count($output)), 2); ?>
    <?php foreach ($output as $line => $code): ?>
        <div class="output-line">
            <div class="output-line-number"><?= str_pad($line + 1, $padding_length, "0", STR_PAD_LEFT) ?></div>
            <div class="output-line-code"><?= htmlentities($code) ?></div>
        </div>
    <?php endforeach ?>
<?php endif ?>
