<?php
	/*
	Plugin Name: Shelter Directory
	Description: Database of Shelter information
	Version: 1.0
	Author: Kristoff Ampong
	*/
	
	// shortcode for the Search Shelter Form

	add_shortcode("search_shelter", "search_shelter_handler");

	function search_shelter_handler() {
		$output = search_shelter_function();

		return $output;
	}

	function search_shelter_function() {
		$form = '
			<form role="search" method="post" id="searchform" action="'.home_url( '/' ).'?page_id=167">
				<table>
					<tbody><tr>
						<td class="form_label">Shelter Name</td>
						<td><input type="text" value="" name="shelter_name" id="shelter_name"></td>
					</tr>
					<tr>
						<td class="form_label">State</td>
						<td>
							<select name="state" id="state">
							<option value="" selected=""></option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
						</td>
					</tr>
					<tr>
						<td class="form_label">City</td>
						<td><input type="text" value="" name="city" id="city"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="SUBMIT" id="submit"></td>
					</tr>
					<tr>
						<td class="form_label">Or</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="button" name="submit_search_shelter" value="ADD A SHELTER" id="add"></td>
					</tr>
				</tbody>
			</table>
		</form>
		';

		return $form;
	}

	// shortcode for the Search Shelter Form result

	add_shortcode("search_shelter_result", "search_shelter_result_handler");

	function search_shelter_result_handler() {
		$output = search_shelter_result_function();
		
		return $output;
	}

	function search_shelter_result_function() {
		global $wpdb;

		$name = $_POST['shelter_name'];
		$state  = $_POST['state'];

		if ($name != "" && $state == "")
			$query = $wpdb->get_results("SELECT * FROM shelter WHERE name LIKE '%$name%'", ARRAY_A) or die(mysql_error());	
		else if ($state != "" && $name == "")
			$query = $wpdb->get_results("SELECT * FROM shelter WHERE state_s='$state'", ARRAY_A) or die(mysql_error());	
		else
			$query = $wpdb->get_results("SELECT * FROM shelter", ARRAY_A);

		foreach ($query as $row) {
			if ($row['address_google'] == "") $map = "";
			else $map = "<br><iframe
							width='600'
							height='450'
							frameborder='0' style='border:0'
							src='https://www.google.com/maps/embed/v1/place?key=AIzaSyBDtxieKrQwBJ5HSwDH-M55qFw6sJmn_9s&q=".$row['address_google']."'>
						  </iframe>";

			echo
				"<b>Shelter ID: </b>". $row['shelterid'] ."<br/>
				<b>Name: </b>". $row['name'] ."<br/>
				<b>Address Web: </b>". $row['address_web'] ."<br/>
				<b>Address Google: </b>". $row['address_google'] ."<br/>
				<b>Phone Web: </b>". $row['phone_web'] ."<br/>
				<b>Phone Google: </b>". $row['phone_google'] ."<br/>
				<b>Latitude: </b>". $row['latitude'] ."<br/>
				<b>Longitude: </b>". $row['longitude'] ."<br/>
				<b>Postal Code: </b>". $row['postal_code'] ."<br/>
				<b>Country: </b>". $row['country'] ."<br/>
				<b>Route: </b>". $row['route'] ."<br/>
				<b>Street Number: </b>". $row['street_number'] ."<br/>
				<b>State L: </b>". $row['state_l'] ."<br/>
				<b>State S: </b>". $row['state_s'] ."<br/>
				<b>Website: </b>". $row['website'] ."<br/>
				<b>Description: </b>". $row['description'] ."<br/>
				".$map."
				<hr/>
				";
		}
	}

	// shortcode for all the Shelter Directory

	add_shortcode("shelter_directory", "shelter_directory_handler");

	function shelter_directory_handler() {
		$output = shelter_directory_function();

		return $output;
	}

	function shelter_directory_function() {
		global $wpdb;

		$query = $wpdb->get_results("SELECT * FROM shelter", ARRAY_A);

		foreach ($query as $row) {
			if ($row['address_google'] == "") $map = "";
			else $map = "<br><iframe
							width='600'
							height='450'
							frameborder='0' style='border:0'
							src='https://www.google.com/maps/embed/v1/place?key=AIzaSyBDtxieKrQwBJ5HSwDH-M55qFw6sJmn_9s&q=".$row['address_google']."'>
						  </iframe>";

			echo
				"<b>Shelter ID: </b>". $row['shelterid'] ."<br/>
				<b>Name: </b>". $row['name'] ."<br/>
				<b>Address Web: </b>". $row['address_web'] ."<br/>
				<b>Address Google: </b>". $row['address_google'] ."<br/>
				<b>Phone Web: </b>". $row['phone_web'] ."<br/>
				<b>Phone Google: </b>". $row['phone_google'] ."<br/>
				<b>Latitude: </b>". $row['latitude'] ."<br/>
				<b>Longitude: </b>". $row['longitude'] ."<br/>
				<b>Postal Code: </b>". $row['postal_code'] ."<br/>
				<b>Country: </b>". $row['country'] ."<br/>
				<b>Route: </b>". $row['route'] ."<br/>
				<b>Street Number: </b>". $row['street_number'] ."<br/>
				<b>State L: </b>". $row['state_l'] ."<br/>
				<b>State S: </b>". $row['state_s'] ."<br/>
				<b>Website: </b>". $row['website'] ."<br/>
				<b>Description: </b>". $row['description'] ."<br/>
				".$map."
				<hr/>
				";
		}
	}

	// for the administration page
	add_action('admin_menu','shelter_directory_menu');

	function shelter_directory_menu(){
		add_options_page('Shelter Directory Administration', 'Shelter Directory', 'manage_options', 'shelter-directory-plugin-menu', 'shelter_directory_option');
	}

	function shelter_directory_option(){
		include('admin/admin.php');
	}
?>