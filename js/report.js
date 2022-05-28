document.querySelector("#reportbtn").addEventListener("click", function() {

    let reportingUser = this.dataset.reportingUser;
    let reportedUser = this.dataset.reportedUser;
    let report = this.dataset.report;

    console.log(reportingUser);
    console.log(reportedUser);


    let formData = new FormData();
    formData.append("reportingUser", reportingUser);
    formData.append("reportedUser", reportedUser);
    formData.append("report", report);

    fetch("ajax/report.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        this.dataset.report = result.body;
        if(result.body == "1"){
            document.querySelector('#reportTxt').innerHTML = "remove report";
        }
        else if(result.body == "0"){
            document.querySelector('#reportTxt').innerHTML = "report";
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });


});
