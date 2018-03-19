<?php foreach ($packages as $package): ?>
    <div class="package">
        <?php if (isset($package->homepage)): ?>
            <a href="<?= $package->homepage ?>" target="_blank"><?= $package->name ?> <code><?= $package->version ?></code></a>
        <?php else: ?>
            <a href="<?= $package->source->url ?>" target="_blank"><?= $package->name ?> <code><?= $package->version ?></code></a>
        <?php endif ?>
        <a href="#" data-name="<?= $package->name ?>" class="uninstall">&times;</a>
    </div>
<?php endforeach ?>
