function exportTableToExcel() {
    // Sélectionner la table
    const table = document.getElementById("myTable");
    
    // Convertir la table en feuille de calcul
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(table);
    XLSX.utils.book_append_sheet(wb, ws, "Feuille1");
    
    // Enregistrer le fichier Excel
    XLSX.writeFile(wb, "table.xlsx");
}

function exportToExcel() {
	// var location = 'data:application/vnd.ms-excel;base64,';
	// var excelTemplate = '<html> ' +
	// 	'<head> ' +
	// 	'<meta http-equiv="content-type" content="text/plain; charset=UTF-8"/> ' +
	// 	'</head> ' +
	// 	'<body> ' +
	// 	document.querySelector(".printable_area").innerHTML +
	// 	'</body> ' +
	// 	'</html>'
	// window.location.href = location + window.btoa(excelTemplate);

    var table = document.getElementById('bilan-2'); // id of table
    var tableHTML = table.outerHTML;
    var fileName = 'download.xls';
  
    var a = document.createElement('a');
    tableHTML = tableHTML.replace(/  /g, '').replace(/ /g, '%20'); // replaces spaces
    a.href = 'data:application/vnd.ms-excel,' + tableHTML;
    a.setAttribute('download', fileName);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function exportToExcel_2 () {
    const workbook = new ExcelJS.Workbook();
    const table = document.getElementById('bilan-2'); // id of table
    alert('Hello');
    workbook.creator = 'H KREMER';
    workbook.lastModifiedBy = 'Me';
    workbook.created = new Date(2025, 1, 21);
    workbook.modified = new Date();
    workbook.lastPrinted = new Date(2025, 1, 21);
    const worksheet = workbook.addWorksheet('New Sheet');
    const headerRow =worksheet.addRow([]);
    const headerCells = table.getElementsByTagName('th');
    for (let i = 0; i < headerCells.length; i++) {
        headerRow.getCell(i + 1).value = headerCells[i].innerText;
        headerRow.getCell(i + 1).fill = {type: 'pattern', pattern: 'solid', fgColor:{argb: 'F08080'}};
    }
    const rows = table.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        const rowData = []
        for (let j = 0; j < cells.length; j++) {
            rowData.push(cells[j].innerText);
        }
        worksheet.addRow(rowData);
    }

    workbook.xlsx.writeBuffer().then(function (buffer) {
        const blob =  new Blob([buffer], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
        saveAs(blob, 'table.xlsx');
    });
    // red tab colour
    // const worksheet = workbook.addWorksheet('New Sheet', {properties:{tabColor:{argb:'FFC0000'}}});

    // hide grid lines
    // const worksheet = workbook.addWorksheet('New Sheet', {views: [{showGridLines: false}]});

    // freeze first row and column
    // const worksheet = workbook.addWorksheet('New Sheet', {views:[{state: 'frozen', xSplit: 1, ySplit:1}]});

    // pageSetup settings for A4 - landscape
    //const worksheet =  workbook.addWorksheet('New Sheet', {
        // pageSetup:{paperSize: 9, orientation:'landscape'}
    // });

    // headers and footers
    // const worksheet = workbook.addWorksheet('New Sheet', {
        // headerFooter: {oddFooter: "Page &P of &N";, oddHeader: 'Odd Page'}
    //  });

    // worksheet.autoFilter = 'A1:C1';

    // await workbook.xlsx.writeFile('Hello');



}