$(document).ready(function () {
  let chart = null;
  let departments = [];
  let doctors = [];
  let statistics = [];

  fetchDepartments();
  loadStatistics();

  $("#department").change(function () {
    let doctorsDropdown = $("#doctor");
    doctorsDropdown.empty();
    doctorsDropdown.append("<option value='' selected>All Doctors</option>");

    loadStatistics();
    fetchDoctors();
  });

  $("#doctor").change(function () {
    loadStatistics();

    if ($("#doctor").val() != "" || $("#department").val() != "") {
      fetchChartStatistics();
    }
  });

  function validateDate() {
    if ($("#start-date").val() > $("#end-date").val()) {
      $("#end-date").val($("#start-date").val());
    }
  }

  $("#start-date, #end-date").change(function () {
    validateDate();

    if ($("#start-date").val() != "" && $("#end-date").val() != "") {
      loadStatistics();
      fetchChartStatistics();
    }
  });

  function fetchDepartments() {
    $.ajax({
      type: "GET",
      url: "get_departments.php",
      success: function (response) {
        let depDropdown = $("#department");
        departments = JSON.parse(response);

        departments.forEach((department) => {
          depDropdown.append(
            "<option value='" +
              department["department_id"] +
              "'>" +
              department["department_name"] +
              "</option>",
          );
        });

        fetchChartStatistics();
      },
    });
  }

  function fetchDoctors() {
    $.ajax({
      type: "GET",
      url: "../../helper/get_doctors.php",
      data: {
        department_id: $("#department").val(),
      },
      success: function (response) {
        doctors = JSON.parse(response);

        if ($("#department").val() != "") {
          let doctorsDropdown = $("#doctor");
          doctors.forEach((doctor) => {
            doctorsDropdown.append(
              "<option value='" +
                doctor["staff_id"] +
                "'>" +
                doctor["name"] +
                "</option>",
            );
          });
        }

        fetchChartStatistics();
      },
    });
  }

  function loadStatistics() {
    // load statistics for the statistic card above the graph
    $.ajax({
      type: "GET",
      url: "get_statistics.php",
      data: {
        department_id: $("#department").val(),
        doctor_id: $("#doctor").val(),
        start_date: $("#start-date").val(),
        end_date: $("#end-date").val(),
      },
      success: function (response) {
        statistics = JSON.parse(response);

        $("#total-appointments-card h2").text(statistics["total_appointments"]);
        $("#scheduled-appointments-card h2").text(
          statistics["scheduled_appointments"],
        );
        $("#completed-appointments-card h2").text(
          statistics["completed_appointments"],
        );
        $("#cancelled-appointments-card h2").text(
          statistics["cancelled_appointments"],
        );
        $("#total-articles-written-card h2").text(statistics["total_articles"]);
      },
    });
  }

  async function fetchStatistics(departmentId, staffId) {
    // get statistics to be used for the graph
    return $.ajax({
      type: "GET",
      url: "get_statistics.php",
      dataType: "json", // automatically convert the result fetched to object
      data: {
        department_id: departmentId,
        doctor_id: staffId,
        start_date: $("#start-date").val(),
        end_date: $("#end-date").val(),
      },
    });
  }

  async function fetchChartStatistics() {
    datasets = [];

    if ($("#department").val() == "") {
      // all departments is selected
      for (let dep of departments) {
        let stats = await fetchStatistics(dep["department_id"], "");

        let statsArray = [
          stats["total_appointments"],
          stats["scheduled_appointments"],
          stats["completed_appointments"],
          stats["cancelled_appointments"],
        ];

        datasets.push({
          label: dep["department_name"],
          data: statsArray,
          borderWidth: 1,
        });
      }
    } else if ($("#doctor").val() == "") {
      // one department selected and all doctors selected
      for (let doc of doctors) {
        let stats = await fetchStatistics(
          $("#department").val(),
          doc["staff_id"],
        );

        let statsArray = [
          stats["total_appointments"],
          stats["scheduled_appointments"],
          stats["completed_appointments"],
          stats["cancelled_appointments"],
        ];

        datasets.push({
          label: doc["name"],
          data: statsArray,
          borderWidth: 1,
        });
      }
    } else {
      // one department and one doctor selected
      let stats = await fetchStatistics(
        $("#department").val(),
        $("#doctor").val(),
      );

      let statsArray = [
        stats["total_appointments"],
        stats["scheduled_appointments"],
        stats["completed_appointments"],
        stats["cancelled_appointments"],
      ];

      datasets.push({
        label: $("#doctor option:selected").html() ?? "Doctor",
        data: statsArray,
        borderWidth: 1,
      });
    }

    loadChart();
  }

  function loadChart() {
    if (chart) {
      chart.destroy();
    }

    let chartHtml = document.getElementById("chart");

    let appointmentCategories = [
      "Total Appointments",
      "Scheduled Appointments",
      "Completed Appointments",
      "Cancelled Appointments",
    ];

    let departmentNames = [];

    // all departments is selected
    chart = new Chart(chartHtml, {
      type: "bar",
      data: {
        labels: appointmentCategories,
        datasets: datasets,
      },
      options: {
        scales: {
          y: { beginAtZero: true },
        },
      },
    });

    // if ($("#department").val() == "") {
    //   // all departments is selected
    //   chart = new Chart(chartHtml, {
    //     type: "bar",
    //     data: {
    //       labels: appointmentCategories,
    //       datasets: datasets,
    //     },
    //     options: {
    //       scales: {
    //         y: { beginAtZero: true },
    //       },
    //     },
    //   });
    // } else if ($("#doctor").val() == "") {
    //   // one department selected and all doctors selected
    //   chart = new Chart(chartHtml, {
    //     type: "bar",
    //     data: {
    //       labels: appointmentCategories
    //     }
    //   })
    // } else {
    //   // one department and one doctor selected
    // }
  }

  // if (role == "admin") {
  //   // if user is an admin
  //   $("#department").change(function () {
  //     let department = $("#department").val();
  //     let doctor = $("#doctor").val();

  //     if (chart) {
  //       chart.destroy();
  //     }

  //     let chartContext = document.getElementById("chart");

  //     if (department == "") {
  //       chart = new Chart(chartContext, {
  //         type: "bar",
  //         data: {
  //           labels: [
  //             "Heart Specialist Department",
  //             "Dental Treatment Department",
  //             "Children Healthcare Department",
  //           ],
  //           datasets: [
  //             {
  //               label: "Dr. Ahmad",
  //               data: [4],
  //               borderWidth: 1,
  //             },
  //             {
  //               label: "Dr. Sarah",
  //               data: [20, 6, 7],
  //               borderWidth: 1,
  //             },
  //             {
  //               label: "Dr. Ali",
  //               data: [11, 13, 21],
  //               borderWidth: 1,
  //             },
  //           ],
  //         },
  //         options: {
  //           scales: {
  //             y: { beginAtZero: true },
  //           },
  //         },
  //       });
  //     } else {
  //       chart = new Chart(chartContext, {
  //         type: "bar",
  //         data: {
  //           labels: ["Dr. Ahmad", "Dr. Sarah", "Dr. Ali"],
  //           datasets: [
  //             {
  //               label: "Scheduled",
  //               data: [10, 13, 20],
  //               borderWidth: 1,
  //             },
  //             {
  //               label: "Completed",
  //               data: [12, 5, 10],
  //               borderWidth: 1,
  //             },
  //             {
  //               label: "Cancelled",
  //               data: [8, 7, 3],
  //               borderWidth: 1,
  //             },
  //           ],
  //         },
  //         options: {
  //           scales: {
  //             y: { beginAtZero: true },
  //           },
  //         },
  //       });
  //     }
  //   });
  // } else {
  //   // if user is a doctor
  //   $("#start-date, #end-date").change(function () {
  //     let startDate = $("#start-date").val();
  //     let endDate = $("#end-date").val();

  //     if (!startDate || !endDate) {
  //       return;
  //     }

  //     if (startDate > endDate) {
  //       $("#end-date").val(startDate);
  //     }

  //     if (chart) {
  //       chart.destroy();
  //     }

  //     let chartContext = document.getElementById("chart");

  //     chart = new Chart(chartContext, {
  //       type: "bar",
  //       data: {
  //         labels: ["30/5/2026", "31/5/2026", "1/6/2026", "2/6/2026"],
  //         datasets: [
  //           {
  //             label: "Scheduled",
  //             data: [10, 13, 20, 11],
  //             borderWidth: 1,
  //           },
  //           {
  //             label: "Completed",
  //             data: [12, 5, 10, 15],
  //             borderWidth: 1,
  //           },
  //           {
  //             label: "Cancelled",
  //             data: [8, 7, 3, 20],
  //             borderWidth: 1,
  //           },
  //         ],
  //       },
  //       options: {
  //         scales: {
  //           y: { beginAtZero: true },
  //         },
  //       },
  //     });
  //   });
  // }
});
