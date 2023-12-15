<!-- Change password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModal">Change password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="changepassword-username" class="col-form-label">Username</label>
            <input type="text" class="form-control" id="changepassword-username" value="" disabled>
        </div>
        <div class="mb-3">
            <label for="changepassword-password" class="col-form-label">Password</label>
            <input type="password" class="form-control" id="changepassword-password" value="">
        </div>
        <div class="mb-3">
            <label for="changepassword-confirmpassword" class="col-form-label">Confirm password</label>
            <input type="password" class="form-control" id="changepassword-confirmpassword" value="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Modify</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var targetModal = document.getElementById('changePasswordModal');

    targetModal.addEventListener('shown.bs.modal', function (event) {
        var button = event.relatedTarget;
        var value = button.getAttribute('data-bs-value');
        $('#changepassword-username').val(value)
    });
});

$('#changePasswordModal .btn-primary').click(function() {
    var username = $('#changepassword-username').val()
    var password = $('#changepassword-password').val();
    var confirmPassword = $('#changepassword-confirmpassword').val();
    if (password !== confirmPassword) {
        alert('Please re-enter your password.');
        return;
    }
    $.ajax({
          type: 'POST',
          url: './db-script/change-password.php',
          data: { username: username,
            password: password
          },
          dataType: 'json',
          success: function(response) {
              if (response.status) {
                  logEverything('People_ID', ownerId, '', '', '','GET', 'People');
                  location.href='./db-script/log-out.php';
              }
          },
          error: function(error) {
              console.log('Error while changing a password', error);
          }
      });

})
</script>

<!-- People -->
<div class="modal fade" id="deletePeopleModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Are you sure you are going to delete this data?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="delete-people-id" value="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editPeopleModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="edit-people-id" value="">
          <div class="mb-3">
            <label for="edit-people-name" class="col-form-label">Name</label>
            <input type="text" class="form-control" id="edit-people-name">
          </div>
          <div class="mb-3">
            <label for="edit-people-address" class="col-form-label">Address</label>
            <input type="text" class="form-control" id="edit-people-address">
          </div>
          <div class="mb-3">
            <label for="edit-people-licence" class="col-form-label">Licence Number</label>
            <input type="text" class="form-control" id="edit-people-licence">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Modify</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addPeopleModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add a person</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="add-people-name" class="col-form-label">Name</label>
          <input type="text" class="form-control" id="add-people-name">
        </div>
        <div class="mb-3">
          <label for="add-people-address" class="col-form-label">Address</label>
          <input type="text" class="form-control" id="add-people-address">
        </div>
        <div class="mb-3">
          <label for="add-people-licence" class="col-form-label">Licence Number</label>
          <input type="text" class="form-control" id="add-people-licence">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Add</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var targetModal = document.getElementById('editPeopleModal');

    targetModal.addEventListener('shown.bs.modal', function (event) {
        var button = event.relatedTarget;
        var value = button.getAttribute('data-bs-value').split('&');
        var message = {
            "action": value[0],
            "id": value[1]
        };
        
        // AJAX request using jQuery
        $.ajax({
            type: 'POST',
            url: './db-script/get-data.php',
            data: { json: JSON.stringify(message) },
            dataType: 'json',
            success: function(response) {
                if (response && response.length > 0) {
                    var personData = response[0];
                    console.log(personData);
                    // Update modal title
                    var modalTitle = targetModal.querySelector('.modal-title');
                    modalTitle.textContent = "Editing #" + personData['People_ID'];
                    // Update form fields
                    var form = targetModal.querySelector('form');
                    $('#edit-people-id').val(personData['People_ID']);
                    form.querySelector('#edit-people-name').value = personData['People_name'];
                    form.querySelector('#edit-people-address').value = personData['People_address'];
                    form.querySelector('#edit-people-licence').value = personData['People_licence'];
                } else {
                    console.log('No data received');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX error:', textStatus, errorThrown);
            }
        });
    });
});
$('#editPeopleModal .btn-primary').click(function() {
    var id = $('#edit-people-id').val();
    var name = $('#edit-people-name').val();
    var address = $('#edit-people-address').val();
    var licence = $('#edit-people-licence').val();
    if (!name || !address || !licence) {
        alert("You should not leave any fields blank.");
        return;
    }
    console.log(id,name,address,licence);
    var reloadContent = function() {
        $('#output').load('./db-script/people/people.php');
    };
    
    $.ajax({
        type: 'POST',
        url: './db-script/people/edit-person.php',
        data: { id: id,
          name:name,
          address:address,
          licence:licence
        },
        dataType: 'json',
        success: function(response) {
            console.log("Success: ", response)
            reloadContent();    
        },
        error: function(error) {
            console.log(error);
        }
    });
});
$('#addPeopleModal .btn-primary').click(function() {
    var name = $('#add-people-name').val();
    var address = $('#add-people-address').val();
    var licence = $('#add-people-licence').val();
    if (!name || !address || !licence) {
        alert("You should not leave any fields blank.");
        return;
    }
    var reloadContent = function() {
        $('#output').load('./db-script/people/people.php');
    };
    addNewPerson(name, address, licence, reloadContent);
});

$('#deletePeopleModal .btn-primary').click(function() {
    var id = $('#delete-people-id').val();
    var reloadContent = function() {
        $('#output').load('./db-script/people/people.php');
    };
    $.ajax({
        type: 'POST',
        url: './db-script/people/delete-person.php',
        data: { id: id
        },
        dataType: 'json',
        success: function(response) {
            console.log("Success: ", response)
            logEverything('People_ID', response.id, '', response.id, '','DELETE', 'People');
            reloadContent();    
        },
        error: function(error) {
            console.log(error);
        }
    });

});

document.addEventListener('DOMContentLoaded', function () {
    var targetModal = document.getElementById('deletePeopleModal');

    targetModal.addEventListener('shown.bs.modal', function (event) {
        var button = event.relatedTarget;
        var value = button.getAttribute('data-bs-value');
        $('#delete-people-id').val(value);
    })}
);
</script>

<!-- Vehicle Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Vehicle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="vehicle-type" class="col-form-label">Type</label>
            <input type="text" class="form-control" id="vehicle-type">
          </div>
          <div class="mb-3">
            <label for="vehicle-colour" class="col-form-label">Colour</label>
            <input type="text" class="form-control" id="vehicle-colour">
          </div>
          <div class="mb-3">
            <label for="vehicle-licence" class="col-form-label">Licence plate number</label>
            <input type="text" class="form-control" id="vehicle-licence">
          </div>
          <div class="mb-3">
            <label for="vehicle-people-name" class="col-form-label">Owner</label>
            <select class="form-control" id="vehicle-people-name">
              <option value="">Select Owner</option>
            </select>
          </div>
          <div class="mb-3" id="newPersonFields"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Add</button>
      </div>
    </div>
  </div>
</div>

<!-- Vehicle: search for people -->
<script>
function loadOwners() {
    $.ajax({
        type: 'GET',
        url: './db-script/vehicle/get-owners.php',
        dataType: 'json',
        success: function(response) {
            console.log("People loaded" ,response);
            var $dropdown = $('#vehicle-people-name');
            $dropdown.empty();
            $dropdown.append('<option value="no">No owner</option>');
            $dropdown.append('<option value="new">Create a new person</option>');
            response.forEach(function(owner) {
                $dropdown.append('<option value="' + owner.People_ID + '">' + owner.People_name + ' '+  owner.People_licence+ '</option>');
            });
            
        },
        error: function(error) {
            console.log(error);
        }
    });
}
// Load information of people
$(document).ready(function() {
    loadOwners();
    loadVehicles();
    loadOffences()
});
// Change person selection dropdown menu
$('#people-name').change(function() {
    var ownerId = $(this).val();
    if (ownerId) {
        $.ajax({
            type: 'GET',
            url: './db-script/vehicle/get-owner-details.php',
            data: { ownerId: ownerId },
            success: function(response) {
                var details = JSON.parse(response);
                $('#vehicle-people-address').val(details.address);
                $('#vehicle-people-licence').val(details.licence);
                logEverything('People_ID', ownerId, '', '', '','GET', 'People');
            },
            error: function(error) {
                console.log(error);
            }
        });
    } else {
        $('#vehicle-people-address').val('');
        $('#vehicle-people-licence').val('');
    }
});
</script>
<script>
$('#vehicle-people-name').change(function() {
    var selectedValue = $(this).val();
    if (selectedValue === "new") {
        // Show additional fields for new person
        var newPersonHtml = `
            <div class="mb-3">
                <label for="new-person-name" class="col-form-label">Name</label>
                <input type="text" class="form-control" id="new-person-name">
            </div>
            <div class="mb-3">
                <label for="new-person-address" class="col-form-label">Address</label>
                <input type="text" class="form-control" id="new-person-address">
            </div>
            <div class="mb-3">
                <label for="new-person-licence" class="col-form-label">Licence Number</label>
                <input type="text" class="form-control" id="new-person-licence">
            </div>
        `;
        $('#newPersonFields').html(newPersonHtml);
    } else {
        // Hide additional fields
        $('#newPersonFields').empty();
    }
});
$('#addVehicleModal .btn-primary').click(function() {
    var vehicleType = $('#vehicle-type').val();
    var vehicleColour = $('#vehicle-colour').val();
    var vehicleLicence = $('#vehicle-licence').val();
    var ownerId = $('#vehicle-people-name').val();
    var reloadContent = function() {
        $('#output').load('./db-script/vehicle/vehicle.php');
    };
    if (ownerId === "new") {
        // Add new person to database
        var name = $('#new-person-name').val();
        var address = $('#new-person-address').val();
        var licence = $('#new-person-licence').val();
        
        addNewPerson(name, address, licence, function(newOwnerId) {
            // After adding the new person, add the vehicle
            addVehicleToPerson(newOwnerId, vehicleType, vehicleColour, vehicleLicence, reloadContent);
        });
    } else if (ownerId === "no") {
      addVehicleToPerson(ownerId, vehicleType, vehicleColour, vehicleLicence, reloadContent);
    } else {
        // Add vehicle to an existing person
        addVehicleToPerson(ownerId, vehicleType, vehicleColour, vehicleLicence, reloadContent);
    }
    $('#output').load('./db-script/vehicle/vehicle.php');
});

function addNewPerson(name, address, licence, callback) {
    $.ajax({
        type: 'POST',
        url: './db-script/people/add-person.php',
        data: { name: name, address: address, licence: licence },
        dataType: 'json',
        success: function(response) {
          console.log(response);
            if (response.status === 'success') {
                var newOwnerId = response.newOwnerId;
                logEverything('People_ID', newOwnerId, '', newOwnerId, '','CREATE', 'People');
                callback(newOwnerId);
            } else {
                console.log('Error adding new person:', response.message);
            }
        },
        error: function(error) {
            console.log('Error adding new person:', error);
        }
    });
}
function addVehicleToPerson(ownerId, type, colour, licence, callback) {
    $.ajax({
        type: 'POST',
        url: './db-script/vehicle/add-vehicle.php',
        dataType: 'json',
        data: { ownerId: ownerId, type: type, colour: colour, licence: licence },
        success: function(response) {
            var newVehicleId = response.newVehicleId;
            console.log('Vehicle added:', response);
            logEverything('Vehicle_ID', newVehicleId, '', ownerId, newVehicleId,'CREATE', 'Vehicle');
            callback(newVehicleId);
        },
        error: function(error) {
            console.log('Error adding vehicle:', error);
        }
    });
}
</script>

<!-- Incident -->
<div class="modal fade" id="addIncidentModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Incident Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="incident-vehicle-id" class="col-form-label">Vehicle</label>
            <select class="form-control" id="incident-vehicle-id">
              <option value="">Select a vehicle</option>
            </select>
          </div>
          <div class="mb-3" id="newVehicleFields"></div>
        </form>
        <form>
          <div class="mb-3" id="personFields"></div>
        </form>
        <div class="mb-3">
            <label for="incident-date" class="col-form-label">Date</label>
            <input type="date" class="form-control" id="incident-date">
        </div>
        <div class="mb-3">
            <label for="incident-report" class="col-form-label">Report</label>
            <input type="text" class="form-control" id="incident-report">
        </div>
        <form>
          <div class="mb-3">
            <label for="incident-offence-id" class="col-form-label">Offence</label>
            <select class="form-control" id="incident-offence-id">
              <option value="">Select a type of offence owner</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Add</button>
      </div>
    </div>
  </div>
</div>

<script>
// $('#addVehicleModal .btn-primary').click(function() {
//     var vehicleType = $('#vehicle-type').val();
//     var vehicleColour = $('#vehicle-colour').val();
//     var vehicleLicence = $('#vehicle-licence').val();
//     var ownerId = $('#vehicle-people-name').val();
//     var reloadContent = function() {
//         $('#output').load('./db-script/vehicle/vehicle.php');
//     };
//     if (ownerId === "new") {
//         // Add new person to database
//         var name = $('#new-person-name').val();
//         var address = $('#new-person-address').val();
//         var licence = $('#new-person-licence').val();
//         addNewPerson(name, address, licence, function(newOwnerId) {
//             // After adding the new person, add the vehicle
//             addVehicleToPerson(newOwnerId, vehicleType, vehicleColour, vehicleLicence, reloadContent);
//         });
//     } else if (ownerId === "no") {
//       addVehicleToPerson(ownerId, vehicleType, vehicleColour, vehicleLicence, reloadContent);
//     } else {
//         // Add vehicle to an existing person
//         addVehicleToPerson(ownerId, vehicleType, vehicleColour, vehicleLicence, reloadContent);
//     }
//     $('#output').load('./db-script/incident/incident.php');
// });
function loadVehicles() {
    $.ajax({
        type: 'GET',
        url: './db-script/vehicle/get-vehicles.php',
        dataType: 'json',
        success: function(response) {
            console.log("Vehicle loaded: ", response);
            var $dropdown = $('#incident-vehicle-id');
            $dropdown.empty();
            $dropdown.append('<option value="">Select a vehicle</option>');
            $dropdown.append('<option value="new">Create a new vehicle</option>');
            response.forEach(function(vehicle) {
                $dropdown.append('<option value="' + vehicle.Vehicle_ID + '">' + vehicle.Vehicle_type + ' '+  vehicle.Vehicle_licence+ '</option>');
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
}
function loadOffences() {
    $.ajax({
        type: 'GET',
        url: './db-script/offence/get-offence.php',
        dataType: 'json',
        success: function(response) {
            console.log("Offence loaded: ", response);
            var $dropdown = $('#incident-offence-id');
            $dropdown.empty();
            $dropdown.append('<option value="">Select a type of offence</option>');
            response.forEach(function(offence) {
                $dropdown.append('<option value="' + offence.Offence_ID + '">' + offence.Offence_description + '</option>');
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
}
$('#incident-vehicle-id').change(function() {
  
    var selectedValue = $(this).val();
    console.log(selectedValue)
    var personFieldHtml = `
            <input type="hidden" id="incident-vehicle-people-id">
            <div class="mb-3">
                <label for="incident-vehicle-people-name" class="col-form-label">Owner name</label>
                <input type="text" class="form-control" id="incident-vehicle-people-name">
            </div>
            <div class="mb-3">
                <label for="incident-vehicle-people-address" class="col-form-label">Owner Address</label>
                <input type="text" class="form-control" id="incident-vehicle-people-address">
            </div>
            <div class="mb-3">
                <label for="incident-vehicle-people-licence" class="col-form-label">Owner Licence Number</label>
                <input type="text" class="form-control" id="incident-vehicle-people-licence">
            </div>
        `;
    if (selectedValue === "new") {
        // Show additional fields for new person
        var newPersonHtml = `
            <div class="mb-3">
                <label for="incident-new-vehicle-type" class="col-form-label">Vehicle type</label>
                <input type="text" class="form-control" id="incident-new-vehicle-type">
            </div>
            <div class="mb-3">
                <label for="incident-new-vehicle-colour" class="col-form-label">Vehicle colour</label>
                <input type="text" class="form-control" id="incident-new-vehicle-colour">
            </div>
            <div class="mb-3">
                <label for="incident-new-vehicle-licence" class="col-form-label">Licence plate number</label>
                <input type="text" class="form-control" id="incident-new-vehicle-licence">
            </div>
        `;
        $('#newVehicleFields').html(newPersonHtml);
        $('#personFields').empty();
        $('#personFields').html(personFieldHtml);
        $('#incident-vehicle-people-id').val("new");
    } else if (selectedValue === "") {
        // Hide additional fields
        $('#newVehicleFields').empty();
        $('#personFields').empty();
    } else {
        $('#newVehicleFields').empty();
        $('#personFields').empty();
        // Put in a person form
        $('#personFields').html(personFieldHtml);
        if (selectedValue) {
            // Make an AJAX call to check if the vehicle has an owner
            $.ajax({
                type: 'POST',
                url: './db-script/vehicle/check-has-owner.php', // Replace with the actual path to your PHP script
                data: { vehicleId: selectedValue },
                dataType: 'json',
                success: function(response) {
                  console.log("Success",response);
                    if (response.hasOwner) {
                        // If the vehicle has an owner, load the owner's name and disable the field
                        $('#incident-vehicle-people-id').val(response.ownerId);
                        $('#incident-vehicle-people-name').val(response.ownerName).prop('disabled', true);
                        $('#incident-vehicle-people-address').val(response.ownerAddress).prop('disabled', true);
                        $('#incident-vehicle-people-licence').val(response.ownerLicence).prop('disabled', true);
                    } else {
                        // If no owner, empty the field and enable it for user input
                        $('#incident-vehicle-people-id').val("new");
                        $('#incident-vehicle-people-name').val('').prop('disabled', false);
                        $('#incident-vehicle-people-address').val('').prop('disabled', false);
                        $('#incident-vehicle-people-licence').val('').prop('disabled', false);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
    } else {
        // If no vehicle is selected, reset and enable the owner field
        $('#incident-vehicle-people-name').val('').prop('disabled', false);
    }
    }
});
$('#addIncidentModal .btn-primary').click(function() {
    // Validate all required fields'
    var vehicleId = $('#incident-vehicle-id').val();
    var ownerId = $('#incident-vehicle-people-id').val();
    var incidentDate = $('#incident-date').val();
    var incidentReport = $('#incident-report').val();
    var offenceId = $('#incident-offence-id').val();
    var reloadContent = function() {
        $('#output').load('./db-script/incident/incident.php');
    };
    if (vehicleId === 'new') {
        var vehicleType = $('#incident-new-vehicle-type').val();
        var vehicleColour = $('#incident-new-vehicle-colour').val();
        var vehicleLicence = $('#incident-new-vehicle-licence').val();
        // console.log(vehicleType,vehicleColour,vehicleLicence,ownerId,offenceId,incidentDate,incidentReport,offenceId);
        if (!vehicleType || !vehicleColour || !vehicleLicence || !ownerId || !offenceId || !incidentDate || !incidentReport || !offenceId) {
          alert("Please fill in all of the provided fields.");
          return;
        }
        if (ownerId === 'new') {
            var ownerName = $('#incident-vehicle-people-name').val();
            var ownerAddress = $('#incident-vehicle-people-address').val();
            var ownerLicence = $('#incident-vehicle-people-licence').val();
            if (!ownerName || !ownerAddress || !ownerLicence || !incidentDate || !incidentReport || !offenceId) {
            alert("Please fill in all of the provided fields.");
            return;
            }
            addNewPerson(ownerName, ownerAddress, ownerLicence, function(newOwnerId) {
                ownerId = newOwnerId;
                addVehicleToPerson(newOwnerId, vehicleType, vehicleColour, vehicleLicence, function(newVehicleId) {
                    vehicleId = newVehicleId;
                    console.log(vehicleId,ownerId,incidentDate,incidentReport,offenceId);
                    addNewIncident(vehicleId, ownerId, incidentDate, incidentReport, offenceId, reloadContent);
                });
                
            });
        } else {
            addVehicleToPerson(ownerName, vehicleType, vehicleColour, vehicleLicence, function(newVehicleId) {
                vehicleId = newVehicleId;
                addNewIncident(vehicleId, ownerId, incidentDate, incidentReport, offenceId, reloadContent);
            });
        }
    } else if (vehicleId === '') {
        // A user submit without filling a vehicle ID
        alert("Please fill in all of the provided fields.");
        return;
    } else {
        addNewIncident(vehicleId, ownerId, incidentDate, incidentReport, offenceId, reloadContent);
    }
})

function addNewIncident(vehicle, owner, date, report, offence, callback) {
    $.ajax({
        type: 'POST',
        url: './db-script/incident/add-incident.php',
        data: { vehicleId: vehicle, 
          ownerId: owner,
          date: date,
          report: report,
          offenceId: offence
        },
        dataType: 'json',
        success: function(response) {
          console.log(response);
            if (response.status === 'success') {
                logEverything('Incident_ID', response.incidentId, response.incidentId, owner, vehicle,'CREATE', 'Incident');
                callback();
            } else {
                console.log('Error adding new incident: ', response.message);
            }
        },
        error: function(error) {
            console.log('Error adding new incident: ', error);
        }
    });
}
</script>
<!-- Associate Fines -->
<div class="modal fade" id="associateFineModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add fines to </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="fine-incident-id" value="">
        <div class="mb-3">
            <label for="fine-amount" class="col-form-label">Fine amount</label>
            <input type="text" class="form-control" id="fine-amount" value="">
        </div>
        <div class="mb-3">
            <label for="fine-point" class="col-form-label">Fine points</label>
            <input type="text" class="form-control" id="fine-point" value="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Set</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var targetModal = document.getElementById('associateFineModal');

  targetModal.addEventListener('shown.bs.modal', function (event) {
      var button = event.relatedTarget;
      var incidentID = button.getAttribute('data-bs-value');
      var modalTitle = targetModal.querySelector('.modal-title');
      modalTitle.textContent = "Add fines to Incident#" + incidentID;
      $('#fine-incident-id').val(incidentID);
      $.ajax({
        type: 'GET',
        url: './db-script/incident/get-fine.php',
        data: { incidentID: incidentID},
        dataType: 'json',
        success: function(response) {
            var amount = response[0].Fine_Amount === 'N/A' ? "" : response[0].Fine_Amount;
            var points = response[0].Fine_Points === 'N/A' ? "" : response[0].Fine_Points;
            $('#fine-amount').val(amount);
            $('#fine-point').val(points);
            logEverything('Incident_ID', incidentID, incidentID, '', '', 'GET', 'Fines');
        },
        error: function(error) {
            console.log('Error retriving fine information: ', error);
        }
      });
  });
});

$('#associateFineModal .btn-primary').click(function() {
    var incidentId = $('#fine-incident-id').val();
    var amount = $('#fine-amount').val();
    var points = $('#fine-point').val();
    var reloadContent = function() {
        $('#output').load('./db-script/incident/incident.php');
    };
    if (Number.isInteger(amount) && Number.isInteger(points)) {
        alert("You should input only a number.");
        return;
    }
    $.ajax({
        type: 'POST',
        url: './db-script/incident/add-fine.php',
        data: { incidentId: incidentId,
          amount: amount,
          points: points
        },
        dataType: 'json',
        success: function(response) {
            logEverything('Incident_ID', incidentId, incidentId, '', '', '', 'CREATE', 'Fines');
            reloadContent();
        },
        error: function(error) {
            console.log('Error while adding fines: ', error);
        }
    });
})
</script>
<!-- Add new officers -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add a new user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="new-user-username" class="col-form-label">Username</label>
            <input type="text" class="form-control" id="new-user-username" value="">
        </div>
        <div class="mb-3">
            <label for="new-user-password" class="col-form-label">Password</label>
            <input type="password" class="form-control" id="new-user-password" value="">
        </div>
        <form>
          <div class="mb-3">
            <label for="new-user-admin" class="col-form-label">User status</label>
            <select class="form-control" id="new-user-admin">
              <option value="0">Officer</option>
              <option value="1">System administrator</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Set</button>
      </div>
    </div>
  </div>
</div>
<script>
$('#addUserModal .btn-primary').click(function() {
    var username = $('#new-user-username').val();
    var password = $('#new-user-password').val();
    var admin = $('#new-user-admin').val();
    var reloadContent = function() {
        $('#output').load('./db-script/users/users.php');
    };
    $.ajax({
          type: 'GET',
          url: './db-script/users/check-username.php',
          data: { username: username},
          dataType: 'json',
          success: function(response) {
              if (response.exist) {
                  alert("You cannot choose this username.");
                  return;
              } else {
                  $.ajax({
                      type: 'POST',
                      url: './db-script/users/add-user.php',
                      data: { username: username,
                        password: password,
                        admin: admin
                      },
                      dataType: 'json',
                      success: function(response) {
                          logEverything('User_Name', username, '', '', '', 'CREATE', 'Users');
                          reloadContent();
                      },
                      error: function(error) {
                          console.log('Error while adding an officer: ', error);
                      }
                  });
              }
          },
          error: function(error) {
              console.log('Error while checking username: ', error);
          }
      });

})

function logEverything(tableId, tableValue, incidentId, peopleId, vehicleId, method, table) {
    $.ajax({
        type: 'POST',
        url: './db-script/log/add-log.php',
        data: { tableId: tableId,
          tableValue: tableValue,
          incidentId: incidentId,
          peopleId, peopleId,
          vehicleId: vehicleId,
          method: method,
          table: table
        },
        dataType: 'json',
        success: function(response) {
            console.log('Logged: ', response);
        },
        error: function(error) {
            console.log('Error while adding a log: ', error.responseText);
        }
    });
  }
</script>