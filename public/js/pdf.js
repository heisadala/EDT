// import { jsPDF } from "jspdf";

function exportTableToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Sélectionner la table
    const table = document.getElementById("myTable");

    // Convertir la table en format autoTable
    doc.autoTable({ html: table });
    
    // Enregistrer ou afficher le fichier PDF
    doc.save("table.pdf");
}

function exportSectionToPDFPortrait() {
    const { jsPDF } = window.jspdf;
    const section = document.getElementById("printable_area");
    
    html2canvas(section).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgWidth = 210; // Largeur A4 en mm
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        
        pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
        pdf.save("section.pdf");
    });
}

function exportSectionToPDFPaysage() {
    const { jsPDF } = window.jspdf;
    const section = document.getElementById("printable_area");
    
    html2canvas(section).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF('l', 'mm', 'a4'); // 'l' pour paysage
        const imgWidth = 297; // Largeur A4 en mm en mode paysage
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        
        pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
        pdf.save("section.pdf");
    });
}

function generatePDF ()  {
    let printable_area = document.querySelector(".printable_area").innerHTML;
    let style = "<style>";
    style = style + " *{font-family: 'Segoe UI'} ";
    style = style + " h1, h2{text-align: center; font-weight: 400; margin: 0} ";
    style = style + " th{color: red;} ";
    style = style + " tr{color: blue;} ";
    style = style + " td{color: red;} ";
    style = style + " </style> ";

    let windowObj = window.open("", "", "width=900, height=700");
    windowObj.document.write(style);
    windowObj.document.write(printable_area);
    windowObj.document.close();
    windowObj.document.print();
}

function generatePDF_2 ()  {
    // let printable_area = document.querySelector(".printable_area").innerHTML;

    // let pdf = new jsPDF("p", "pt", "a4");
    // let options = { pagesplit: true };
    // pdf.addHTML($(document.getElementById("bilan-2")), options, () => {
    //     pdf.save("myDoc.pdf");
    // });

    const { jsPDF } = window.jspdf;
    var pdf = new jsPDF("p", "pt", "a4",{compress: 'true'});

    pdf.html(document.querySelector(".printable_area"), {
        callback: function (pdf) {
            // var totalPages = pdf.internal.getNumberOfPages();
            // for (var i = 2; i <= totalPages; i++) {
            //     // Go to each page after the first and delete it
            //     pdf.setPage(i);
            //     pdf.deletePage(i);
            //     i--;
            //     totalPages--;
            // }
          pdf.save("myDoc.pdf");
        },
        x: 10,
        y: 10
     });
}