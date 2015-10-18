        <h2>Потребители</h2>
        <?php
        $user_count = user_count();
        $suffix = ($user_count != 1) ? 'и' : '';
        ?>
        <p>Ние имаме <?php echo $user_count; ?> регистриран<?php echo $suffix; ?> потребител<?php echo $suffix; ?>.</p>