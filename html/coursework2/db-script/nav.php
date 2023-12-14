<nav class='navbar navbar-expand-sm navbar-dark bg-dark sticky-top'>
    <a class="navbar-brand">&nbsp;&nbsp;<i class="bi bi-database-fill fa-lg"></i>&nbsp;Police Database</a>
    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
        <ul class='navbar-nav me-auto'>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown px-2">
                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Database
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/people/people.php')">People</a></li>
                        <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/vehicle/vehicle.php')">Vehicle</a></li>
                        <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/incident/incident.php')">Report</a></li>
                        <!-- <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/incident.php')">Incident</a></li>
                        <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/offence.php')">Offence</a></li>
                        <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/ownership.php')">Ownership</a></li>
                        <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/users.php')">Users</a></li> -->
                    </ul>
                </li>
            </ul>
        </div>
        </ul>
        <li class="nav-item dropdown">
                    <button class="<?php if ($_SESSION["admin"] == 1) {echo 'btn btn-danger dropdown-toggle';} else {echo 'btn btn-dark dropdown-toggle';}?>" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator
                    </button>
                    <ul class="<?php if ($_SESSION["admin"] == 1) {echo "dropdown-menu dropdown-menu-warning";} else {echo "dropdown-menu dropdown-menu-warning";}?>">
                        <?php if ($_SESSION["admin"] == 0) {
                            echo "<li><a class='dropdown-item disabled'>You must be an administrator </br>to perform these actions.</a></li><div class='dropdown-divider'></div>";}?>
                        <li><a class="<?php if ($_SESSION["admin"] == 1) {echo "dropdown-item";} else {echo "dropdown-item disabled";}?>" href="#" onClick= "$('#output').load('./db-script/users/users.php')">Add new officers</a></li>
                        <li><a class="<?php if ($_SESSION["admin"] == 1) {echo "dropdown-item";} else {echo "dropdown-item disabled";}?>" href="#" onClick= "$('#output').load('./db-script/incident/incident.php')">Update fines</a></li>
                        <li><a class="<?php if ($_SESSION["admin"] == 1) {echo "dropdown-item";} else {echo "dropdown-item disabled";}?>" href="#" onClick= "$('#output').load('./db-script/log/log.php')">Audit log</a></li>
                        <li><a class="<?php if ($_SESSION["admin"] == 1) {echo "dropdown-item";} else {echo "dropdown-item disabled";}?>" href="#" onClick= "$('#output').load('./db-script/reset-database.php')">Reset database</a></li>      
                    </ul>
        </li>
        <li class="nav-item dropdown">
                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        if ($_SESSION["admin"] == 1) {
                            echo "Logged in as [Admin] ".ucfirst($_SESSION["user"])."&nbsp;&nbsp<i class='bi bi-person-fill-gear'></i>";
                        } else {
                            echo "Logged in as ".ucfirst($_SESSION["user"])."&nbsp;&nbsp<i class='bi bi-gear-fill'></i>";
                        }
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#" onClick= "$('#output').load('./db-script/change-password.php')">Change Password</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="#" onClick= "location.href='./db-script/log-out.php'">Log out</a></li>
                    </ul>
        </li>

    </div>
</nav>

