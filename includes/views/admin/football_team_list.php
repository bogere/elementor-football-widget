<?php

function bg_display_football_team_list() {

    // global $wpdb;
    // $leagueTable = $wpdb->prefix . 'football_league';
    // $leagueList = $wpdb->get_results("SELECT id,name,description from $leagueTable");

    ?>

    <div class="wrap">
        <h5>Football Teams</h5>
        <button  class="btn btn-primary add-team">Add Football Team</button>
        <!--- container for adding the football teams -->
    <div id="new_football_team_form">
    <h5>New Football Team</h5>
    <form id="NewTeamForm" action=""  enctype="multipart/form-data">
        <div class = "row">
            <div class = "col-8">
                <label>Team Name</label>
                <input type="text" id="team_name" name="team_name" class="form-control" required>
            </div>
            <div class = "col-8">
                <label>team_nickname</label>
				<input type="text" id="team_nickname" name="team_nickname" class="form-control" required>
            </div>
            <div class = "col-8">
               <div class="form-group">
                    <label for="team_league">Team League:</label>
                    <select class="form-control" id="team_league" name = "team_league">
                        <option value="">Select the football league</option>
                        <?php
                            global $wpdb;
                            $leagueTable = $wpdb->prefix . 'football_league';
                            $leagueList = $wpdb->get_results("SELECT id,name,description from $leagueTable", ARRAY_A);
                            if(count($leagueList) > 0){
                                foreach($leagueList as $league){
                                  echo "<option value=". $league[id] .">". $league[name]. "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class = "col-8">
                <label>Team History</label>
                <textarea id="team_history" name="team_history" cols="40" rows="4" class= "form-control"></textarea>
            </div>
            <div class = "col-8">
                <label>Team Logo</label>
                <input type="file" name="team_logo" accept="image/*" class = "form-control"><br>
            </div>
        </div>
          <button type="submit" class="btn btn-success save-btn">Add Team</button>
    </form>
  </div>
        <table class = "table table-bordered soccer-team-table">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Team Logo</th>
                <th>Nickname</th>
                <th>History</th>
                <th> - </th>
            </tr>
            </thead>
            <tbody>
            <?php
                global $wpdb;
                $teamTable = $wpdb->prefix . 'football_teams';
                $teamList = $wpdb->get_results("SELECT id,team_name,team_nickname,team_logo, team_history,league_id from $teamTable");
                foreach ($teamList as $team) {
                   ?>
                <tr>
                    <td><?= $team->id; ?></td>
                    <td><?= $team->team_name; ?></td>
                    <td><?= $team->team_logo; ?></td>
                    <td><?= $team->team_nickname; ?></td>
                    <td><?= $team->team_history; ?></td>
                    <td>
                        <button class='btn btn-info btn-edit ms-2 mt-2'>Edit</button>
                        <button class='btn btn-danger btn-delete ms-2 mt-2'>Delete</button>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>

    
    <?php

}
add_shortcode('bg_football_team_list', 'bg_display_football_team_list');
?>