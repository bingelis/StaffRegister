<?php if (empty($staff)): ?>
No person found.
<?php endif; ?>

<?php foreach ($staff as $person): ?>
=======================================================
    First name:         [ <?= $person->first_name ?> ]
    Last name:          [ <?= $person->last_name ?> ]
    Email:              [ <?= $person->email ?> ]
    Primary phone:      [ <?= $person->primary_phone ?> ]
    Secondary phone:    [ <?= $person->secondary_phone ?> ]
    Comment:            [ <?= $person->description ?> ]
=======================================================
<?php endforeach; ?>
