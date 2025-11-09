<h2><?= $item ? 'Edit' : 'Add' ?> Customer</h2>
<?= form_open($item ? 'customers/update/'.$item->id : 'customers/store'); ?>
  <label>Full Name*
    <input type="text" name="full_name" required
      value="<?= set_value('full_name', $item ? $item->full_name : '') ?>">
  </label>
  <label>Phone
    <input type="text" name="phone"
      value="<?= set_value('phone', $item ? $item->phone : '') ?>">
  </label>
  <label>Note
    <textarea name="note"><?= set_value('note', $item ? $item->note : '') ?></textarea>
  </label>
  <button type="submit">Save</button>
  <a class="button" href="<?= site_url('customers') ?>">Cancel</a>
<?= form_close(); ?>

<?php if (validation_errors()): ?>
  <div class="flash error"><?= validation_errors() ?></div>
<?php endif; ?>
