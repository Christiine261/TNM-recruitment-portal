document.addEventListener('DOMContentLoaded', function () {
  // Function to handle job details using AJAX
  function showJobDetails(jobId) {
      const xhr = new XMLHttpRequest();

      // Replace this with your actual URL
      const url = `job_details.php?id=${jobId}`;

      xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                  try {
                      const data = JSON.parse(xhr.responseText);

                      if (data.error) {
                          console.error(data.error);
                          // Handle error, show a message, or perform other actions
                      } else {
                          // Populate job details content <h2>${data.job_title}</h2>
                          const jobDetailsContent = document.getElementById('job-details-content');

                          jobDetailsContent.innerHTML = `<div class="job-details-header">
                                                          <img src="assets/img/tnmy.jpg" alt="Company Logo" class="job-logo">
                                                          <h3><b>${data.job_title}</b></h3>
                                                          <div id="close-button-container">
                                                            <button id="close-button">&times;</button>
                                                          </div>
                                                        </div>
                                                        <p>TNM invites suitably qualified candidates to fill the position of <strong>${data.job_title}</strong>.</p>
                                                        
                                                        <p><strong>Position overview</strong></p>
                                                        <ul>${data.job_description}</ul>
                                                        <p><strong>Qualifications, experience and desired skills</strong></p>
                                                        <ul>${createBulletList(data.qualifications)}</ul>
                                                        <p><strong>Key Responsibilities</strong></p>
                                                        <ul>${createBulletList(data.responsibilities)}</ul>
                                                        <p><strong>Deadline:</strong> ${data.deadline_date}</p>`;

                          // Show the job details section
                          const jobDetailsSection = document.getElementById('job-details');
                          jobDetailsSection.classList.remove('hidden');
                      }
                  } catch (error) {
                      console.error('Error parsing JSON:', error);
                  }
              } else {
                  console.error('Error fetching job details. Status:', xhr.status);
                  // Handle error, show a message, or perform other actions
              }
          }
          const allJobs = document.getElementById('all-jobs');
          allJobs.classList.toggle('collapsed', true);

          const jobDetails = document.getElementById('job-details');
          jobDetails.classList.add('expanded');
          //jobDetails.classList.toggle('expanded', true);

          // Add event listener for the close button
          const closeButton = document.getElementById('close-button');
          closeButton.addEventListener('click', function () {
              // Toggle the collapsed class back on #all-jobs
              const allJobs = document.getElementById('all-jobs');
              allJobs.classList.toggle('collapsed', false);

              // Toggle the expanded class back on #job-details
              const jobDetails = document.getElementById('job-details');
              jobDetails.classList.add('hidden');
              jobDetails.classList.remove('expanded');
          });
      };

      const applyNowButton = document.getElementById('apply-button');
      applyNowButton.addEventListener('click', function () {
          handleApplyNow(jobId);
      });

      // Open the request
      xhr.open('GET', url, true);

      // Send the request
      xhr.send();
  }

  function createBulletList(text) {
      const items = text.split('\n');
      return items.map(item => `<li>${item}</li>`).join('');
  }

  function handleApplyNow(jobId) {
      const applyUrl = `apply_job.php?jobId=${jobId}`;
      window.location.href = applyUrl;
  }

  // Event listener for clicking on a job post
  document.querySelectorAll('.job-post').forEach(jobPost => {
      jobPost.addEventListener('click', function () {
          const jobId = this.getAttribute('data-job-id');
          showJobDetails(jobId);
      });
  });
  
});
