<h2>Customers</h2>
<form method="get" action="<?= site_url('customers') ?>" style="margin-bottom:8px">
  <input type="text" name="q" placeholder="Search name/phone..." value="<?= html_escape($q) ?>">
  <button type="submit">Search</button>
  <a href="<?= site_url('customers') ?>">Reset</a>
  <a class="button" href="<?= site_url('customers/create') ?>" style="float:right">+ Add</a>
</form>

<table>
  <thead>
    <tr>
      <th>#</th><th>Name</th><th>Phone</th><th>Note</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $i => $it): ?>
    <tr>
      <td><?= $i+1 ?></td>
      <td><?= html_escape($it->full_name) ?></td>
      <td><?= html_escape($it->phone) ?></td>
      <td><?= nl2br(html_escape($it->note)) ?></td>
      <td>
        <a href="<?= site_url('customers/edit/'.$it->id) ?>">Edit</a> |
        <a href="<?= site_url('customers/delete/'.$it->id) ?>" onclick="return confirm('Delete this customer?')">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($items)): ?>
      <tr><td colspan="5">No data</td></tr>
    <?php endif; ?>
  </tbody>
</table>
