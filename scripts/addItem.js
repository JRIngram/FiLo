window.onload = function maxDate(){
  var today = new Date().toISOString().split('T')[0];
  document.getElementById("found_date").setAttribute('max', today);
  console.log(today);
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
    var electronicQuestions = '<div class="form-group"><label for="electronicType">Type of Electronic: </label><input class="form-control" type="text" name="electronicType"/></div>' +
    '<div class="form-group"><label for="brand">Brand: </label><input class="form-control" type="text" name="brand"/></div>' +
    '<div class="form-group"><label for="model">Model: </label><input class="form-control" type="text" name="model"/></div>';
    specificQuestions.innerHTML = electronicQuestions;
  }

  //Adds unique questions for found jewellery.
  else if(categoryValue == "jewellery"){
    var jewelleryQuestions = '<div class="form-group"><label for="metalType">Metal Type:</label><input class="form-control" type="text" name="metalType"/></div>' +
    '<div class="form-group"><label for="jewelleryType">Jewellery Type: </label><input class="form-control" type="text" name="jewelleryType"/></div>';
    specificQuestions.innerHTML = jewelleryQuestions;
  }

  //Adds unique questions for found pets.
  else if(categoryValue == "pet"){
    var petQuestions = '<div class="form-group"><label for="pet_name">Pet Name:</label><input class="form-control" type="text" name="pet_name"/></div>' +
    '<div class="form-group"><label for="animal">Animal: </label><input class="form-control" type="text" name="animal"/></div>' +
    '<div class="form-group"><label for="breed">Breed: </label><input class="form-control" type="text" name="breed"/></div>' +
    '<div class="form-group"><label for="collar_colour">Collar Colour: </label><input class="form-control" type="text" name="collar_colour"/><br/>';
    specificQuestions.innerHTML = petQuestions;
  }

  else{
    specificQuestions.innerHTML = "";
  }
}
