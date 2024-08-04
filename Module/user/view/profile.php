<?php get_view_part('inc.header'); ?>

<?php get_view_part('inc.navbar'); ?>




<div class="container">
	<div class="row justify-content-center py-5">
		<div class="col-md-4">
			<table class="table">
			  <tbody>
			    <tr>
			      <th class="text-end">First Name</th>
			      <td class="text-start"><?php echo User()->fname; ?></td>
			    </tr>
			    <tr>
			      <th class="text-end">Last Name</th>
			      <td class="text-start"><?php echo User()->lname; ?></td>
			    </tr>
			    <tr>
			      <th class="text-end">Display Name</th>
			      <td class="text-start"><?php echo User()->display_name; ?></td>
			    </tr>
			    <tr>
			      <th class="text-end">Username</th>
			      <td class="text-start"><?php echo User()->username; ?></td>
			    </tr>
			    <tr>
			      <th class="text-end">Email</th>
			      <td class="text-start"><?php echo User()->email; ?></td>
			    </tr>
			    <tr>
			      <th class="text-end">Mobile Number</th>
			      <td class="text-start"><?php echo User()->mobile; ?></td>
			    </tr>
			    <tr>
			      <th class="text-end">Edith info</th>
			      <td class="text-start"><a href="#" class="btn btn-warning btn-sm">Edith</a></td>
			    </tr>
			  </tbody>
			</table>
		</div>
	</div>
</div>






<?php get_view_part('inc.footer'); ?>