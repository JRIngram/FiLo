window.onload = function maxDate(){
  var today = new Date().toISOString().split('T')[0];
  document.getElementById("found_date").setAttribute('max', today);
  console.log("UPDATE!");
};

/**
* Adds specific questions for the different item categories on the open categories page
*/
function updateAddItemForm(){
  var specificQuestions = document.getElementById("specificQuestions");
  var categoryDropdown = document.getElementById("category");
  var categoryValue = categoryDropdown.value;

  //Adds unique questions for found phones.
  if(categoryValue == "electronic"){
    var electronicQuestions = '<div class="form-group"><label for="electronicType">Type of Electronic: </label><input class="form-control" type="text" pattern="^[a-zA-Z ]{0,60}$" title="Must only contain alphabetical characters and be less than 60 characters in length." name="electronicType" required="true"/></div>' +
    '<div class="form-group"><label for="brand">Brand: </label><input class="form-control" type="text" name="brand" pattern="^[a-zA-Z0-9 ]{0,20}$" title="Must contain only alphanumerical characters and be less than 20 characters in length" required="true"/></div>' +
    '<div class="form-group"><label for="model">Model: </label><input class="form-control" type="text" name="model" pattern="^[a-zA-Z0-9 ]{0,20}$" title="Must contain only alphanumerical characters and be less than 20 characters in length" required="true"/></div>';
    specificQuestions.innerHTML = electronicQuestions;
  }

  //Adds unique questions for found jewellery.
  else if(categoryValue == "jewellery"){
    var jewelleryQuestions = '<div class="form-group"><label for="metalType">Metal Type:</label><input class="form-control" type="text" name="metalType" pattern="^[a-zA-Z ]{0,20}$" title="Use only alphabtical characters and must be less than 20 characters in length" required="true"/></div>' +
    '<div class="form-group"><label for="jewelleryType">Jewellery Type: </label>' +
        '<select class="form-control" name="jewelleryType" required="true">' +
          '<option value="">Please Select...</option>' +
          '<option value="necklace">Necklace</option>' +
          '<option value="bracelet">Bracelet</option>' +
          '<option value="ring">Ring</option>' +
          '<option value="ear-ring">Ear Ring</option>' +
          '<option value="other">Other</option>'
        '</select>'
    '</div>';
    specificQuestions.innerHTML = jewelleryQuestions;
  }

  //Adds unique questions for found pets.
  else if(categoryValue == "pet"){
    var petQuestions = '<div class="form-group"><label for="pet_name">Pet Name:</label><input class="form-control" type="text" name="pet_name" pattern="^[a-zA-Z ]{0,30}$" title="Must contain alphaberical characters and spaces only. Must be 30 characters or less." required="true"/></div>' +
    '<div class="form-group"><label for="animal">Animal: </label><input class="form-control" type="text" name="animal" pattern="^[a-zA-Z ]{0,40}$" title="Must contain alphaberical characters and spaces only. Must be 40 characters or less." required="true"/></div>' +
    '<div class="form-group"><label for="breed">Breed: </label><input class="form-control" type="text" name="breed" pattern="^[a-zA-Z ]{0,30}$" title="Must contain alphaberical characters and spaces only. Must be 30 characters or less." required="true"/></div>' +
    '<div class="form-group"><label for="collar_colour">Collar Colour: </label><input class="form-control" type="text" name="collar_colour" pattern="^[a-zA-Z ]{0,20}$" title="Must contain alphaberical characters and spaces only. Must be 20 characters or less." required="true"/><br/>';
    specificQuestions.innerHTML = petQuestions;
  }

  else{
    specificQuestions.innerHTML = "";
  }
}
