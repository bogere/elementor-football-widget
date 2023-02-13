<?php

function bg_display_football_team_league_list() {
    ?>
    <style>
        table {
            border-collapse: collapse;

        }

        /* table, td, th {
            border: 1px solid black;
            padding: 20px;
            text-align: center;
        } */
    </style>
    <div class="wrap">
        <h5>Football Team Leagues</h5>
        <button  class="btn btn-primary add-league">Add Football League</button>
        <!--- container for adding the football teams -->
    <div id="new_football_team_league_form">
    <h5>New Team League</h5>
    <form id="NewFootballLeagueForm" action="" >
        <div class = "row">
            <div class = "col-8">
                <label>League Name</label>
				<input type="text" id="league_name" name="league_name" class="form-control" required>
            </div>
            <div class = "col-8">
                <label>Description</label>
				<input type="text" id="description" name="description" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success save-btn">Add Team</button>
    </form>
  </div>
        <table class = "table table-bordered soccer-league-table">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th> Action </th>
            </tr>
            </thead>
            <tbody>
            <?php
                global $wpdb;
                $table_name = $wpdb->prefix . 'football_league';
                $leagueList = $wpdb->get_results("SELECT id,name,description from $table_name");
                foreach ($leagueList as $league) {
            ?>
                    <tr>
                        <td><?= $league->id; ?></td>
                        <td><?= $league->name; ?></td>
                        <td><?= $league->description; ?></td>
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
add_shortcode('bg_football_team_league', 'bg_display_football_team_league_list');
?>