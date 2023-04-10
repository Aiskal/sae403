// Get all the buttons
const eleveBtn = document.getElementById('eleve-btn');
const profBtn = document.getElementById('prof-btn');
const adminBtn = document.getElementById('admin-btn');
const autreBtn = document.getElementById('autre-btn');
const allBtn = document.getElementById('all-btn');

// Get all the divs to be shown or hidden
const eleveDiv = document.getElementById('admin-eleve');
const profDiv = document.getElementById('admin-prof');
const adminDiv = document.getElementById('admin-admin');
const autreDiv = document.getElementById('admin-autre');

// Add event listeners to the buttons
eleveBtn.addEventListener('click', showEleveDiv);
profBtn.addEventListener('click', showProfDiv);
adminBtn.addEventListener('click', showAdminDiv);
autreBtn.addEventListener('click', showAutreDiv);
allBtn.addEventListener('click', showAllDivs);

function showEleveDiv() {
  // Hide all the other divs
  hideAllDivs();
  // Show the eleve div
  eleveDiv.style.display = 'block';
}

function showProfDiv() {
  // Hide all the other divs
  hideAllDivs();
  // Show the prof div
  profDiv.style.display = 'block';
}

function showAdminDiv() {
  // Hide all the other divs
  hideAllDivs();
  // Show the admin div
  adminDiv.style.display = 'block';
}

function showAutreDiv() {
  // Hide all the other divs
  hideAllDivs();
  // Show the autre div
  autreDiv.style.display = 'block';
}

function showAllDivs() {
  // Show all the divs
  eleveDiv.style.display = 'block';
  profDiv.style.display = 'block';
  adminDiv.style.display = 'block';
  autreDiv.style.display = 'block';
}

function hideAllDivs() {
  // Hide all the divs
  eleveDiv.style.display = 'none';
  profDiv.style.display = 'none';
  adminDiv.style.display = 'none';
  autreDiv.style.display = 'none';
}
