<?php foreach ($packages as $package): ?>
    <div class="package">
        <?php if (isset($package->homepage)): ?>
            <a href="<?= $package->homepage ?>" class="package-name" target="_blank"><?= $package->name ?> <code><?= $package->version ?></code></a>
        <?php else: ?>
            <a href="<?= $package->source->url ?>" class="package-name" target="_blank"><?= $package->name ?> <code><?= $package->version ?></code></a>
        <?php endif ?>
        <?php if ($package->protected !== true): ?>
            <a href="#" data-name="<?= $package->name ?>" class="uninstall">&times;</a>
        <?php endif ?>
    </div>
<?php endforeach ?>
