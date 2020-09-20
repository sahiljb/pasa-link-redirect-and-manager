<?php $all_redirects = $this->get_all_redirectors(); ?>

<div class="jumbotron jumbotron-fluid py-4 bg-info text-white">
	<div class="container">
		<h1 class="display-6 text-white"><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p class="float-right">by <a class="text-white" href="http://sahilbuddhadev.me/" target="_blank">Sahil Buddhadev</a> | v 1.0.0</p>
		<p class="lead">Manage your all redirectors here.</p>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col pb-5">
			<div class="card col p-0 border-info">
				<div class="card-header bg-info text-white">
					<b>Add New Rule</b>
				</div>
				<div class="card-body">
					<div class="card-text">
						<p class="display-6">Add your old path <code>/old-link/</code> in the old link field, and the new path <code>/new-link/</code> in the new link field.</p>
					</div>
					<form action="javascript:void(0);" method="post" id="formAddNewRule">
						<div class="form-row">
							<div class="col">
								<input type="text" class="form-control border-info" placeholder="Title" name="rule_name" id="rule_name" required="required" value="">
							</div>
							<div class="col">
								<input type="text" class="form-control border-info" placeholder="Group" name="links_group" id="links_group" value="">
							</div>
							<div class="col">
								<input type="text" class="form-control border-info" placeholder="Old Link" name="old_link" id="old_link" required="required" value="">
							</div>
							<div class="col">
								<input type="text" class="form-control border-info" placeholder="New Link" name="new_link" id="new_link" required="required" value="">
							</div>
							<div class="col text-center">
								<button type="submit" class="btn btn-info" id="addNewRule">Add New Rule</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php if ( !empty( $all_redirects ) ): ?>
		
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Title</th>
				<th scope="col">Group</th>
				<th scope="col">Old Link</th>
				<th scope="col">New Link</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				
				foreach ($all_redirects  as $redirector):
				
				$redirector_data = $this->get_redirector( $redirector);
			?>
			<tr class="pasaRule" id="pasaRule-<?php echo $redirector ?>">
				<th scope="row"><?php echo $i ?></th>
				<td><?php echo $redirector_data['title'] ?></td>
				<td><?php echo $redirector_data['links_group'] ?></td>
				<td>
					<a href="<?php echo $redirector_data['old_link'] ?>" target="_blank">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-link-45deg" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.715 6.542L3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.001 1.001 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
							<path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 0 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 0 0-4.243-4.243L6.586 4.672z"/>
						</svg>
						<?php echo $redirector_data['old_link'] ?>
					</a>
				</td>
				<td><?php echo $redirector_data['new_link'] ?></td>
				<td>
					<!-- <a href="" class="text-decoration-none text-info px-1">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
							<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
						</svg>
					</a> -->
					<a href="javascript:void(0);" data-id="<?php echo $redirector ?>" class="text-decoration-none text-danger px-1 removeThisRule">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
							<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
						</svg>
					</a>
				</td>
			</tr>
			<?php
				$i++;

				endforeach;
			?>
		</tbody>
	</table>

	<?php endif ?>
</div>