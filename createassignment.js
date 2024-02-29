const user_id = localStorage.getItem('user_id');

window.onload = async function () {
  let currentDate = new Date();
  const dueDateInput = document.getElementById('due-date');
  const formattedCurrentDate = currentDate.toISOString().slice(0, 10); // Format the current date as YYYY-MM-DD

  dueDateInput.setAttribute('min', formattedCurrentDate);
  const fetchClasses = await fetch(
    'http://localhost/akP/myClassesTeacher.php',
    {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ user_id }),
    }
  );
  const classes = await fetchClasses.json();

  addClassesToClassAssignDiv(classes);
};

async function handleAssignButton() {
  const assignment_name = document.getElementById('assignment-title');
  const class_id = document.getElementById('class-assign-select');
  let duedate = document.getElementById('due-date');

  const assignment_duedate = new Date(duedate.value).toISOString();

  let assignment_date = new Date();
  const formatted_date = assignment_date.toISOString();
  const assignment_description = document.getElementById('details');
  const attachments = document.getElementById('attachments-file');

  console.log('Due: ', assignment_duedate);
  console.log('Date: ', assignment_date);

  const inputs_array = [
    assignment_name,
    assignment_duedate,
    assignment_description,
  ];

  document.getElementById('validation-message').innerText = '';

  if (assignment_name.value === '') {
    document.getElementById('validation-message').innerText =
      '*Please enter the assignment title.';
    return;
  }

  if (assignment_duedate === '') {
    document.getElementById('validation-message').innerText =
      '*Please select the due date for the assignment.';
    return;
  }

  const assignment = {
    assignment_name: assignment_name.value,
    assignment_description: assignment_description.value,
    class_id: class_id.value,
    assignment_date: formatted_date,
    assignment_duedate: assignment_duedate,
    teacher_id: user_id,
  };

  console.log(assignment);

  const postAssignment = await fetch(
    'http://localhost/google-clone/Google-Classroom-Clone/api/controllers/createAssignment.php',
    {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(assignment),
    }
  );

  const res = await postAssignment.json();
  console.log(res.status);
  inputs_array.forEach((e) => {
    e.value = '';
  });
}

document
  .getElementById('assign-button')
  .addEventListener('click', handleAssignButton);

function addClassesToClassAssignDiv(classes) {
  const classAssignSelect = document.getElementById('class-assign-select');

  while (classAssignSelect.firstChild) {
    classAssignSelect.removeChild(classAssignSelect.firstChild);
  }

  classes.forEach((className) => {
    const option = document.createElement('option');
    option.value = className.class_id;
    option.textContent = className.class_name;
    classAssignSelect.appendChild(option);
  });
}
