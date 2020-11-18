/*functions for Test Record Page*/

function showManagerPages(userType){
  if (userType=="Manager"){
    pages = document.getElementsByClassName("managerShow");
    for (i=0;i<pages.length;i++){
      pages[i].style.display = "block";
    }
  }
}

function generateTestTable(){//generate the patient table which list the test details
    for (i = 0; i < testList.length; i += 1){
    // initialsing the variables
    var testID = testList[i]["testID"];
    var testdate = testList[i]["testDate"];
    var patusername = testList[i]["patUserName"];
    var patupswd = testList[i]["patUserPassword"];
    var patname = testList[i]["patName"];
    var pattype = testList[i]["patType"];
    var patsymptom = testList[i]["patSymptom"];
    appendTest(testID,patusername,patupswd,patname,pattype,patsymptom,testdate);

    //display test result if complete
    
    if(testList[i]["patStatus"] == "completed"){
      appendCompleteTest(testList[i]["testID"],testList[i]["resultDate"],testList[i]["result"]);
    }
  }
}

//append update those tests with complete status
function appendCompleteTest(testID,resultDate,result){
  let tbody = document.getElementsByTagName("tbody")[0];
  let rows = tbody.rows;
  for (i=0;i<rows.length;i++){
    if(rows[i].cells[0].innerHTML == testID){
      
      var day = resultDate.getDate();
      if (day<10){
        day = "0"+day;
      }
      var month = resultDate.getMonth()+1
      if(month<10){
        month = "0"+month;
      }
      rows[i].cells[7].innerHTML = resultDate.getFullYear()+" "+month+" "+day;
      rows[i].cells[8].innerHTML = result
      rows[i].cells[9].innerHTML = "complete";
      rows[i].cells[10].getElementsByTagName("button")[0].setAttribute("class","btn btn-success");
      break;
    }
  }
}

//append test with pending status
function appendTest(testID,patUsername,patPassword,patName,patType,symptom,testDate){
  var username = patUsername;
  var password = patPassword;
  var name = patName;
  var type = patType;
  var testId = testID;
  

  let tbody = document.getElementsByTagName("tbody")[0];
  let row = tbody.insertRow(tbody.length);

  testIdcell = row.insertCell(0);
  testIdcell.innerHTML = testId;
  datecell = row.insertCell(1);
  var day = testDate.getDate();
  if (day<10){
    day = "0"+day;
  }
  var month = testDate.getMonth()
  if(month<10){
    month = "0"+month;
  }
  datecell.innerHTML = testDate.getFullYear()+" "+month+" "+day;
  patusernamecell = row.insertCell(2);
  patusernamecell.innerHTML = username;
  patnamecell = row.insertCell(3);
  patnamecell.innerHTML = name;
  patpwsdcell = row.insertCell(4);
  patpwsdcell.innerHTML = password;
  patTypecell = row.insertCell(5);
  patTypecell.innerHTML = type;
  symptomcell = row.insertCell(6);
  symptomcell.innerHTML = symptom;
  resultDatecell = row.insertCell(7);
  resultDatecell.innerHTML = "-";
  resultcell = row.insertCell(8);
  resultcell.innerHTML = "-";
  statuscell = row.insertCell(9);
  statuscell.innerHTML = "pending"
  viewcell = row.insertCell(10);
  var viewBtn = document.createElement("button");
  viewBtn.setAttribute("class","btn btn-danger");
  viewBtn.innerHTML ="view";
  viewBtn.setAttribute("onclick","displayTestModal(\""+testId+"\")");
  viewcell.appendChild(viewBtn);
  
}

//create new test from the test modal
function createNewTest(testDate){
  event.preventDefault(); 
  patUsername = document.getElementById("inputpatuname").value;
  patPassword = document.getElementById("inputpatpwsd").value;
  patName = document.getElementById("inputpatname").value;
  patType = document.getElementById("selectpattype").value;
  symptom = document.getElementById("inputsymptoms").value;
  appendTest(patUsername,patPassword,patName,patType,symptom,testDate);
  document.getElementById("test-form").reset();
  $('#addTestRecordModal').modal('hide');
  }

 //generate test ID
 // T + first and last two alphabets of the username + date
 //example, username: OACP5419, date = 2020/4/24
 // T + OA + 19 + 2020 + 04 + 24
 //TOA1920200424
function generateTestID(uname,tdate){
  uname = (uname.slice(0,2) + uname.slice(-2));
  tdate=tdate.toISOString().slice(0,10).split("-");
  tyear= tdate[0];
  tmonth = tdate[1];
  tday = tdate[2];
  return "T"+uname+tyear+tmonth+tday;
}


function checkExistingUser(){
  //Check for the same username in the testlist
  var patuname = document.getElementById("inputpatuname").value;
  let tbody = document.getElementsByTagName("tbody")[0];
  testlist = tbody.rows;

  for (i=0;i<testlist.length;i++){
    if(testlist[i].cells[2].innerHTML == patuname){
      //auto fille the patient username, name and password
      document.getElementById("inputpatuname").value = testlist[i].cells[2].innerHTML;
      document.getElementById('inputpatname').value = testlist[i].cells[3].innerHTML;
      document.getElementById('inputpatpwsd').value = testlist[i].cells[4].innerHTML;
      document.getElementById('selectpattype').focus();
      break;
    }
  }
}

//Change the content of the test modal to the selected test
function displayTestModal(testId){
  let tbody = document.getElementsByTagName("tbody")[0];
  testlist = tbody.rows;
  for (i=0;i<testlist.length;i++){
  if(testlist[i].cells[0].innerHTML == testId){// match testID
    //replace the content
    document.getElementById("test-modal-testId").innerHTML = testlist[i].cells[0].innerHTML;
    document.getElementById('test-modal-testDate').innerHTML = testlist[i].cells[1].innerHTML;
    document.getElementById('test-modal-patUsername').innerHTML = testlist[i].cells[2].innerHTML;
    document.getElementById('test-modal-patName').innerHTML = testlist[i].cells[3].innerHTML;
    document.getElementById('test-modal-patPassword').innerHTML = testlist[i].cells[4].innerHTML;
    document.getElementById('test-modal-patType').innerHTML = testlist[i].cells[5].innerHTML;
    document.getElementById('test-modal-symptoms').innerHTML = testlist[i].cells[6].innerHTML;
    document.getElementById('test-modal-resultDate').innerHTML = testlist[i].cells[7].innerHTML;
    document.getElementById('test-modal-result').innerHTML = testlist[i].cells[8].innerHTML;
    document.getElementById('test-modal-status').innerHTML = testlist[i].cells[9].innerHTML;
    break;
    }
  }
  $('#test-modal').modal();//activate the test modal
}

function sortTable(n) {
  var table,rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementsByTagName("TABLE")[0];
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare, one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place, based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
/*functions for Test Record Page*/


/*functions for Test Kit Page*/
let tkCount = 3;

let tkList =
    [
        { iD: "1", name: "VWE2", stock: "4" },
        { iD: "2", name: "QEW1", stock: "5" },
        { iD: "3", name: "EWR5", stock: "2" },
    ];

function generateTableTK() {
    for (i = 0; i < tkList.length; i++) {
        var iD = tkList[i]["iD"];
        var name = tkList[i]["name"];
        var stock = tkList[i]["stock"];
        insertTestkit(iD,name,stock);
    }
}

function addTestkit() {
    event.preventDefault();
    tkCount++;
    iD = tkCount;
    amount = 0;
    testkitName = document.getElementById("tkName").value;
    let tabObj = document.getElementById("tk-table");
    let tab = tabObj.getElementsByTagName("tbody")[0];
    let row = tab.rows;
    
    for (i = 0; i < row.length; i++) {
        console.log(row[i].cells[1].innerHTML);
        console.log(testkitName);
        if (row[i].cells[1].innerHTML == testkitName) {
            document.getElementById("tk-form").reset();
            alert("testkit already exists");
            break;

        }
        else { 
            insertTestkit(iD, testkitName, amount);
            document.getElementById("tk-form").reset();
            alert("successfully added");
            break;
        }
    }
}

function insertTestkit(iD, testkitName, amount) {
    var name = testkitName;
    var stock = amount;
    var tkId = iD;
    let tabObj = document.getElementById("tk-table");
    let tab = tabObj.getElementsByTagName("tbody")[0];
    let row = tab.insertRow(tab.length);

    let tkIdCell = row.insertCell(0);
    tkIdCell.innerHTML = tkId;
    let tkNameCell = row.insertCell(1);
    tkNameCell.innerHTML = name;
    let stockCell = row.insertCell(2);
    stockCell.innerHTML = stock;
    updateCell = row.insertCell(3);
    var updateBtn = document.createElement("button");
    updateBtn.setAttribute("class", "btn btn-success");
    updateBtn.innerHTML = "update";
    updateBtn.setAttribute('onclick', "updateStock(\"" + tkId + "\")")
    updateCell.appendChild(updateBtn);
    deleteCell = row.insertCell(4);
    var deleteBtn = document.createElement("button");
    deleteBtn.setAttribute("class", "btn btn-danger");
    deleteBtn.innerHTML = "delete";
    deleteBtn.setAttribute('onclick', "deleteStock(\"" + tkId + "\")")
    deleteCell.appendChild(deleteBtn);
}

function updateStock(id) {
    var stock = prompt("Please enter the new stock for testkit " + id);
    if (stock != null) {
        let tabObj = document.getElementById("tk-table");
        let tab = tabObj.getElementsByTagName("tbody")[0];
        let row = tab.rows;

        for (i = 0; i < row.length; i++) {
            if (row[i].cells[0].innerHTML == id) {
                row[i].cells[2].innerHTML = stock;
                break;
            }
        }
    }
}

function deleteStock(id) {
    var con = confirm("Testkit with ID "+id+" will be deleted");
    if (con == true) {
        let tabObj = document.getElementById("tk-table");
        let tab = tabObj.getElementsByTagName("tbody")[0];
        let row = tab.rows;
        for (i = 0; i < row.length; i++) {
            if (row[i].cells[0].innerHTML == id) {
                row[i].parentNode.removeChild(row[i]);
                break;
            }
        }
    }
    else {
        
    }
}

function sortTableTK(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("tk-table");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare, one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /*check if the two rows should switch place, based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /*If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
/*functions for Test Kit Page*/


/*functions for Test History Page*/
function generatePatientTableForPatient(targetpatUserName) {
    for (i = 0; i < testList.length; i++){
    var patusername = testList[i]["patUserName"];
      if (patusername == targetpatUserName) {
      var testID = testList[i]["testID"];
      var testdate = testList[i]["testDate"];
      var pattype = testList[i]["patType"];
      var patsymptom = testList[i]["patSymptom"];
      appendTestPatient(testID,patusername,pattype,patsymptom,testdate);
      break;
    }
  }
}

//append test with pending status
function appendTestPatient(testID, patUsername,patType, symptom, testDate) {
    var username = patUsername;
    var type = patType;
    var testId = testID;


    let tbody = document.getElementsByTagName("tbody")[0];
    let row = tbody.insertRow(tbody.length);

    testIdcell = row.insertCell(0);
    testIdcell.innerHTML = testId;
    datecell = row.insertCell(1);
    var day = testDate.getDate();
    if (day < 10) {
        day = "0" + day;
    }
    var month = testDate.getMonth()
    if (month < 10) {
        month = "0" + month;
    }
    datecell.innerHTML = testDate.getFullYear() + " " + month + " " + day;
    patusernamecell = row.insertCell(2);
    patusernamecell.innerHTML = username;
    patTypecell = row.insertCell(3);
    patTypecell.innerHTML = type;
    symptomcell = row.insertCell(4);
    symptomcell.innerHTML = symptom;
    resultDatecell = row.insertCell(5);
    resultDatecell.innerHTML = "-";
    resultcell = row.insertCell(6);
    resultcell.innerHTML = "-";
    statuscell = row.insertCell(7);
    statuscell.innerHTML = "pending"
    viewcell = row.insertCell(8);
    var viewBtn = document.createElement("button");
    viewBtn.setAttribute("class", "btn btn-danger");
    viewBtn.innerHTML = "view";
    viewBtn.setAttribute("onclick", "displayTestModalP(\"" + testId + "\")");
    viewcell.appendChild(viewBtn);

}
function displayTestModalP(testId) {
    let tbody = document.getElementsByTagName("tbody")[0];
    testlist = tbody.rows;
    for (i = 0; i < testlist.length; i++) {
        if (testlist[i].cells[0].innerHTML == testId) {// match testID
            //replace the content
            document.getElementById("test-modal-testId").innerHTML = testlist[i].cells[0].innerHTML;
            document.getElementById('test-modal-testDate').innerHTML = testlist[i].cells[1].innerHTML;
            document.getElementById('test-modal-patUsername').innerHTML = testlist[i].cells[2].innerHTML;
            document.getElementById('test-modal-patType').innerHTML = testlist[i].cells[3].innerHTML;
            document.getElementById('test-modal-symptoms').innerHTML = testlist[i].cells[4].innerHTML;
            document.getElementById('test-modal-resultDate').innerHTML = testlist[i].cells[5].innerHTML;
            document.getElementById('test-modal-result').innerHTML = testlist[i].cells[6].innerHTML;
            document.getElementById('test-modal-status').innerHTML = testlist[i].cells[7].innerHTML;
            break;
        }
    }
    $('#test-modal').modal();//activate the test modal
}
/*functions for Test History Page*/


/*functions for Update Test Page*/
"$testID|$testDate|$patUsername|$patPwsd|$patName|$patType|$symptoms|$resultDate|$patResult|$status"
function generateTestTableForUpdate(testId,testdate,patusername,patupswd,patname,pattype,patsymptom,patstatus){

      //replace the empty value of the table with the selected test details
      document.getElementById("testID").innerHTML = testId;
      document.getElementById("Date").innerHTML = testdate;
      document.getElementById("patUsername").innerHTML = patusername;
      document.getElementById("patName").innerHTML = patname;
      document.getElementById("patPswd").innerHTML = patupswd;
      document.getElementById("patType").innerHTML = pattype;
      document.getElementById("symptoms").innerHTML = patsymptom;
      document.getElementById("status").innerHTML = patstatus;
      
      //create the form to submit result
      var updateTestForm = document.createElement("form");
      updateTestForm.setAttribute("id","update-test-form");
      updateTestForm.setAttribute("method","GET");
      updateTestForm.setAttribute("action","functionPHP/updateTestInDatabase.php");

      //create the first radio button for positive result
      var check1 = document.createElement("div");
      check1.setAttribute("class","form-check form-check-inline");
      var check1Input = document.createElement("input");
      check1Input.setAttribute("class","form-check-input");
      check1Input.setAttribute("name","patResultRadio");
      check1Input.setAttribute("type","radio");
      check1Input.setAttribute("id","check1");
      check1Input.setAttribute("value","1");
      check1Input.checked = true;
      var check1Label = document.createElement("label");
      check1Label.setAttribute("class","form-check-label");
      check1Label.setAttribute("for","check1");
      check1Label.innerHTML = "Positive";
      check1.appendChild(check1Input);
      check1.appendChild(check1Label);

      //create the second radio button for negative result
      var check2 = document.createElement("div");
      check2.setAttribute("class","form-check form-check-inline");
      var check2Input = document.createElement("input");
      check2Input.setAttribute("class","form-check-input");
      check2Input.setAttribute("name","patResultRadio");
      check2Input.setAttribute("type","radio");
      check2Input.setAttribute("id","check2");
      check2Input.setAttribute("value","0");
      var check2Label = document.createElement("label");
      check2Label.setAttribute("class","form-check-label");
      check2Label.setAttribute("for","check2");
      check2Label.innerHTML = "Negative";
      check2.appendChild(check2Input);
      check2.appendChild(check2Label);

      //create the submit button
      var submitbtn = document.createElement("button");
      submitbtn.setAttribute("type","submit")
      submitbtn.setAttribute("class","btn btn-success");
      submitbtn.innerHTML = "Submit";

      var testIDinput = document.createElement("input");
      testIDinput.setAttribute("name","testID");
      testIDinput.setAttribute("value",testId);
      testIDinput.style.display = "none";


      updateTestForm.appendChild(testIDinput);
      updateTestForm.appendChild(check1);//add check1 to the form
      updateTestForm.appendChild(check2);//add check2 to the form
      updateTestForm.appendChild(submitbtn);//add submit button to the form
      document.getElementById("result").appendChild(updateTestForm);//display the form
    }
    
  

function updateTest(){
  event.preventDefault();
  var testResult;
  var radios = document.getElementsByName('patResultRadio');
  for (var i = 0, length = radios.length; i < length; i++) {
    if (radios[i].checked) {
      testResult = radios[i].value;
      break;
    }
  }
  document.getElementById("result").removeChild(document.getElementById("update-test-form"));
  document.getElementById("result").innerHTML = testResult;
  document.getElementById("resultDate").innerHTML = new Date();
  document.getElementById("status").innerHTML = "complete";
}
/*functions for Update Test Page*/


/*functions for Manage Tester Page*/
testOfficerList = [
  {uName:"MICE5241",uPwsd:"abc123",Name:"Misha Justice"},
  {uName:"ATHS2587",uPwsd:"abc123",Name:"Anoushka Griffiths"},
  {uName:"DRTA8596",uPwsd:"abc123",Name:"Declan Huerta"},
  {uName:"ZUME8541",uPwsd:"abc123",Name:"Zaydan Hume"},
  {uName:"JERS5296",uPwsd:"abc123",Name:"Josef Powers"},
]

//generate the tester table
function generateTestOfficerTable(){
  for (i=0;i<testOfficerList.length;i++){
      var testUname = testOfficerList[i]["uName"];
      var testUPwsd = testOfficerList[i]["uPwsd"];
      var testName = testOfficerList[i]["Name"];
      appendTestOfficer(testUname,testUPwsd,testName);
  }
}

//append a tester to the table to display
function appendTestOfficer(uname,pwsd,name){
  let tbody = document.getElementsByTagName("tbody")[0];
  let row = tbody.insertRow(tbody.length);
  testOfficerUnamecell = row.insertCell(0);
  testOfficerPwsdcell = row.insertCell(1);
  testOfficerNamecell = row.insertCell(2);
  testOfficerUnamecell.innerHTML = uname;
  testOfficerPwsdcell.innerHTML = pwsd;
  testOfficerNamecell.innerHTML = name;
}

//create and add a tester
function addTestOfficer(){
  event.preventDefault();
  var testUname = document.getElementById("inputtesteruname").value;
  var testUPwsd = document.getElementById("inputtesterpwsd").value;
  var testName = document.getElementById("inputtetsername").value;
  let tbody = document.getElementsByTagName("tbody")[0];
  let rows = tbody.rows;
  for(i=0;i<rows.length;i++){
      if (rows[i].cells[0].innerHTML == testUname){ //same username
          alert("User with same username already exists");
          break;
      }
      else{
          if(i==(rows.length-1)){//successful created
              appendTestOfficer(testUname,testUPwsd,testName);
              document.getElementById("tester-form").reset();
              $('#addTestOfficerModal').modal('hide');
              break;
          } 
      }
  }
}

//remove tester from the table
function removeTestOfficer(){
  event.preventDefault();
  var testUname = document.getElementById("inputremovetesteruname").value;
  let tbody = document.getElementsByTagName("tbody")[0];
  let rows = tbody.rows;
  for(i=0;i<rows.length;i++){
      if (rows[i].cells[0].innerHTML == testUname){
          if(confirm("Do you wish to remove Tester "+testUname)){
              rows[i].parentNode.removeChild(rows[i]);
              document.getElementById("remove-tester-form").reset();
              $('#removeTestOfficerModal').modal('hide');
          }
          break;
      }
      if(i == (rows.length-1)){
              alert("No tester with Username "+testUname+" is found.");
          }
  }
}
/*functions for Manage Tester Page*/
