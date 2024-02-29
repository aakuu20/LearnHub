window.addEventListener('load', async () => {
    const user_id = localStorage.getItem('user_id');
  
    const user = {
      user_id: user_id,
    };
    sideBar({});
    const response = await fetch(
      'http://localhost/google-clone/Google-Classroom-Clone/api/controllers/myclasses.php',
      {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(user),
      }
    );
  
    const classes = await response.json();
  
    const cardscontainer = document.getElementById('cards-container');
    let card_assignment = [];
  
    const getCardAssignments = async (id) => {
      let arr = [];
      const formData = new FormData();
      formData.append('class_id', id);
  
      let card_assignments = [];
      const assignment = await fetch(
        'http://localhost/google-clone/Google-Classroom-Clone/api/controllers/cardAssignments.php',
        {
          method: 'POST',
          body: formData,
        }
      );
      const res = await assignment.json();
      res.forEach((element) => {
        arr.push(element);
      });
      return arr;
    };
  
    for (single_class of classes) {
      const classid = single_class.class_id;
      const classname = single_class.class_name;
      const class_section = single_class.class_section;
      const class_subject = single_class.class_subject;
      const assignments = await getCardAssignments(classid);
      const [task1, task2] = assignments;
  
      // Function to get the day of the week in text
      function getDayOfWeek(dayIndex) {
        const daysOfWeek = [
          'Sunday',
          'Monday',
          'Tuesday',
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday',
        ];
        return daysOfWeek[dayIndex];
      }
      function getHour(date) {
        const dateObj = new Date(date);
        const formattedDate = `${dateObj.getHours()}:${(
          '0' + dateObj.getMinutes()
        ).slice(-2)} - ${getDayOfWeek(dateObj.getDay())}`;
        return formattedDate;
      }
  
      const date = (task) => {
        if (task) {
          return getHour(task.assignment_duedate);
        }
        return '';
      };
      const description = (task) => {
        if (task) {
          return task.assignment_name;
        }
        return '';
      };
  
      console.log(task1);
      cardscontainer.innerHTML += `
          <li class="card-body flex flex-col">
            <div class="card-header">
              <div class="card-header-content flex flex-col justify-between">
                <div class="card-title flex justify-between">
                  <a class="flex-col underline" href="class.html?class_id=${classid}">
                    <h3 class="class-name">${classname}</h3>
                    <p class="class-subtitle">
                    ${class_section}
                    </p>
                  </a>
                  <div>
                    <a href=""
                      ><img src="../src/assets/images/icons/dots-v white.svg" alt=""
                    /></a>
                  </div>
                </div>
                <div class="card-sub-title">
                  <p class="class-description color-white">${class_subject}</p>
                </div>
              </div>
            </div>
            <div class="card-middle">
              <img
                class="card-profile-img"
                src="../src/assets/images/blueman.png"
                alt=""
              />
              <div class="card-assignment">
              <h3 class="card-duedate" id="">${date(task1)}</h3>
              <p class="card-time-name mb-10px">${description(task2)}</p>
              </div>
              <div class="card-assignment">
              <h3 class="card-duedate" id="">${date(task2)}</h3>
              <p class="card-time-name"> ${description(task1)}</p>
              </div>
            </div>
            <div class="card-footer flex justify-end">
              <div class="card-icon-holder flex justify-center items-center">
                <img src="../src/assets/images/icons/assignment_ind.svg" alt="" />
              </div>
              <div class="card-icon-holder flex justify-center items-center">
                <img src="../src/assets/images/icons/folder.svg" alt="" />
              </div>
            </div>
          </li>
          
          `;
    }
  
    // await getCardAssignments(classes);
  });
  

const add_button = document.getElementById('add-icon');
const add_class_dropdown = document.getElementById('add-class-dropdown');

add_button.addEventListener('click', () => {
  add_class_dropdown.classList.toggle('show');
});

const create_class_button = document.getElementById('create-class');
const create_class_close = document.getElementById('create-class-close');
const create_class_container = document.getElementById(
  'create-class-container'
);
const create_class_button_cancel = document.getElementById(
  'create-class-button-cancel'
);
const create_class_button_create = document.getElementById(
  'create-class-button-create'
);

create_class_button.addEventListener('click', () => {
  create_class_container.classList.add('create-class-container-show');
});

create_class_close.addEventListener('click', () => {
  create_class_container.classList.remove('create-class-container-show');
});

create_class_button_cancel.addEventListener('click', () => {
  create_class_container.classList.remove('create-class-container-show');
  resetCreateClassInputs();
});

const class_name_input = document.getElementById('create-class-name');
const class_section_input = document.getElementById('create-class-section');
const class_subject_input = document.getElementById('create-class-subject');
const class_meeting_link_input = document.getElementById(
  'class-meeting-link-input'
);

function inputAnimation(input) {
  input.addEventListener('click', () => {
    input.parentElement.parentElement
      .querySelector('.create-class-placeholder')
      .classList.add('create-class-placeholder-enabled');
  });
  input.addEventListener('blur', () => {
    if (input.value === '') {
      input.parentElement.parentElement
        .querySelector('.create-class-placeholder')
        .classList.remove('create-class-placeholder-enabled');
    }
  });
}

inputAnimation(class_name_input);
inputAnimation(class_section_input);
inputAnimation(class_subject_input);
inputAnimation(class_meeting_link_input);

function emptyCreateClassInputs() {
  class_name_input.value = '';
  class_section_input.value = '';
  class_subject_input.value = '';
  class_meeting_link_input.value = '';
}

function resetCreateClassInputs() {
  emptyCreateClassInputs();
  class_name_input.parentElement.parentElement
    .querySelector('.create-class-placeholder')
    .classList.remove('create-class-placeholder-enabled');
  class_section_input.parentElement.parentElement
    .querySelector('.create-class-placeholder')
    .classList.remove('create-class-placeholder-enabled');
  class_subject_input.parentElement.parentElement
    .querySelector('.create-class-placeholder')
    .classList.remove('create-class-placeholder-enabled');
  class_meeting_link_input.parentElement.parentElement
    .querySelector('.create-class-placeholder')
    .classList.remove('create-class-placeholder-enabled');
}

function manageCreateButton() {
  class_name_input.addEventListener('input', () => {
    if (class_name_input.value === '') {
      create_class_button_create.disabled = true;
    } else {
      create_class_button_create.disabled = false;
    }
  });
}

create_class_button_create.disabled = true;
addClass();

function addClass() {
  manageCreateButton();

  create_class_button_create.addEventListener('click', async () => {
    if (class_name_input.value === '') {
      class_name_input.classList.add('input-error');
      class_name_input.focus();
    } else {
      const user_id = localStorage.getItem('user_id');

      const new_class = {
        creator_id: user_id,
        class_name: class_name_input.value,
        class_section: class_section_input.value,
        class_subject: class_subject_input.value,
        meeting_link: class_meeting_link_input.value,
      };

      const response = await fetch(
        'http://localhost/google-clone/Google-Classroom-Clone/api/controllers/createClass.php',
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(new_class),
        }
      );

      const response_details = await response.json();
      if (response_details.status == 'Class Added Successfully') {
        resetCreateClassInputs();
        create_class_container.classList.remove('create-class-container-show');

        joinClass(response_details.insert_id, user_id);
      }
    }
  });
}

async function joinClass(class_id, user_id) {
  const new_enrollment = {
    class_id,
    user_id,
    role: 'teacher',
  };

  const response = await fetch(
    'http://localhost/google-clone/Google-Classroom-Clone/api/controllers/joinClass.php',
    {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(new_enrollment),
    }
  );

  const response_details = await response.json();
  if (response_details.status == 'Joined Successfully') {
    window.location.reload();
  }
}
