<?php
if(IN_MANAGER_MODE != "true") {
	die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
}
if(!$modx->hasPermission('view_eventlog')) {
	$modx->webAlertAndQuit($_lang["error_no_privileges"]);
}
?>

<script type="text/javascript" src="media/script/tablesort.js"></script>

<h1>
	<i class="fa fa-calendar"></i><?php echo $_lang['site_schedule']; ?>
</h1>

<div class="section">
	<div class="sectionHeader"><?php echo $_lang["publish_events"] ?></div>
	<div class="sectionBody" id="lyr1">
		<?php
		$rs = $modx->db->select('id, pagetitle, pub_date', $modx->getFullTableName('site_content'), "pub_date > " . time() . "", 'pub_date ASC');
		$limit = $modx->db->getRecordCount($rs);
		if($limit < 1) {
			echo "<p>" . $_lang["no_docs_pending_publishing"] . "</p>";
		} else {
			?>
			<table border="0" cellpadding="2" cellspacing="0" class="sortabletable sortable-onload-3 rowstyle-even" id="table-1" width="100%">
				<thead>
				<tr bgcolor="#CCCCCC">
					<th class="sortable"><b><?php echo $_lang['resource']; ?></b></th>
					<th class="sortable"><b><?php echo $_lang['id']; ?></b></th>
					<th class="sortable"><b><?php echo $_lang['publish_date']; ?></b></th>
				</tr>
				</thead>
				<tbody>
				<?php
				while($row = $modx->db->getRow($rs)) {
					?>
					<tr>
						<td><a href="index.php?a=3&id=<?php echo $row['id']; ?>"><?php echo $row['pagetitle'] ?></a></td>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $modx->toDateFormat($row['pub_date'] + $server_offset_time) ?></td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<?php
		}
		?>

	</div>
</div>


<div class="section">
	<div class="sectionHeader"><?php echo $_lang["unpublish_events"]; ?></div>
	<div class="sectionBody" id="lyr2"><?php
		$rs = $modx->db->select('id, pagetitle, unpub_date', $modx->getFullTableName('site_content'), "unpub_date > " . time() . "", 'unpub_date ASC');
		$limit = $modx->db->getRecordCount($rs);
		if($limit < 1) {
			echo "<p>" . $_lang["no_docs_pending_unpublishing"] . "</p>";
		} else {
			?>
			<table border="0" cellpadding="2" cellspacing="0" class="sortabletable sortable-onload-3 rowstyle-even" id="table-2" width="100%">
				<thead>
				<tr bgcolor="#CCCCCC">
					<th class="sortable"><b><?php echo $_lang['resource']; ?></b></th>
					<th class="sortable"><b><?php echo $_lang['id']; ?></b></th>
					<th class="sortable"><b><?php echo $_lang['unpublish_date']; ?></b></th>
				</tr>
				</thead>
				<tbody>
				<?php
				while($row = $modx->db->getRow($rs)) {
					?>
					<tr>
						<td><a href="index.php?a=3&id=<?php echo $row['id']; ?>"><?php echo $row['pagetitle']; ?></a></td>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $modx->toDateFormat($row['unpub_date'] + $server_offset_time); ?></td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<?php
		}
		?>

	</div>
</div>


<div class="section">
	<div class="sectionHeader"><?php echo $_lang["all_events"]; ?></div>
	<div class="sectionBody"><?php
		$rs = $modx->db->select('id, pagetitle, pub_date, unpub_date', $modx->getFullTableName('site_content'), "pub_date > 0 OR unpub_date > 0", "pub_date DESC");
		$limit = $modx->db->getRecordCount($rs);
		if($limit < 1) {
			echo "<p>" . $_lang["no_docs_pending_pubunpub"] . "</p>";
		} else {
			?>
			<table border="0" cellpadding="2" cellspacing="0" class="sortabletable rowstyle-even" id="table-3" width="100%">
				<thead>
				<tr bgcolor="#CCCCCC">
					<th class="sortable"><b><?php echo $_lang['resource']; ?></b></th>
					<th class="sortable"><b><?php echo $_lang['id']; ?></b></th>
					<th class="sortable"><b><?php echo $_lang['publish_date']; ?></b></th>
					<th class="sortable"><b><?php echo $_lang['unpublish_date']; ?></b></th>
				</tr>
				</thead>
				<tbody>
				<?php
				while($row = $modx->db->getRow($rs)) {
					?>
					<tr class="<?php echo($i % 2 ? 'even' : '') ?>">
						<td><a href="index.php?a=3&id=<?php echo $row['id'] ?>"><?php echo $row['pagetitle'] ?></a></td>
						<td><?php echo $row['id'] ?></td>
						<td><?php echo $row['pub_date'] == 0 ? "" : $modx->toDateFormat($row['pub_date'] + $server_offset_time) ?></td>
						<td><?php echo $row['unpub_date'] == 0 ? "" : $modx->toDateFormat($row['unpub_date'] + $server_offset_time) ?></td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<?php
		}
		?>
	</div>
</div>
