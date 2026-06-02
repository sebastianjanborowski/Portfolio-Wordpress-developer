document.addEventListener('DOMContentLoaded', function () {
    const pdfButton = document.getElementById('generateUsersPdf');
    const pdfMessage = document.getElementById('pdfMessage');

    const PDF_FONT_NAME = 'DejaVuSans';
    const PDF_FONT_STYLE = 'normal';

    const config = window.reportPdfConfig || {};
    const rows = Array.isArray(config.rows) ? config.rows : [];
    const columns = Array.isArray(config.columns) ? config.columns : [];

    if (!pdfButton || !pdfMessage) {
        return;
    }

    pdfButton.addEventListener('click', function (event) {
        event.preventDefault();

        if (!rows.length) {
            showPdfMessage('Brak danych do wygenerowania raportu PDF.');
            return;
        }

        if (!columns.length) {
            showPdfMessage('Brak konfiguracji kolumn raportu PDF.');
            return;
        }

        try {
            generatePdf();
        } catch (error) {
            console.error(error);
            showPdfMessage('Wystąpił błąd podczas generowania pliku PDF.');
        }
    });

    function generatePdf() {
        if (!window.jspdf || !window.jspdf.jsPDF) {
            showPdfMessage('Biblioteka jsPDF nie została załadowana.');
            return;
        }

        const { jsPDF } = window.jspdf;

        const doc = new jsPDF({
            orientation: 'landscape',
            unit: 'mm',
            format: 'a4'
        });

        if (!isPdfFontAvailable(doc, PDF_FONT_NAME)) {
            showPdfMessage('Font PDF nie został poprawnie załadowany.');
            return;
        }

        const pdfHeaders = [columns.map(function (column) {
            return column.label;
        })];

        const pdfBody = rows.map(function (row) {
            return columns.map(function (column) {
                return normalizeValue(row[column.key], column.key);
            });
        });

        doc.setFont(PDF_FONT_NAME, PDF_FONT_STYLE);
        doc.setFontSize(16);
        doc.text(config.title || 'Raport', 14, 15);

        doc.setFont(PDF_FONT_NAME, PDF_FONT_STYLE);
        doc.setFontSize(10);
        doc.text('Tabela źródłowa: ' + (config.sourceTable || '-'), 14, 22);

        doc.autoTable({
            head: pdfHeaders,
            body: pdfBody,
            startY: 28,
            theme: 'grid',
            styles: {
                font: PDF_FONT_NAME,
                fontStyle: PDF_FONT_STYLE,
                fontSize: 7,
                cellPadding: 2,
                overflow: 'linebreak',
                valign: 'middle',
                halign: 'left'
            },
            headStyles: {
                font: PDF_FONT_NAME,
                fontStyle: PDF_FONT_STYLE,
                fillColor: [52, 58, 64],
                textColor: 255,
                halign: 'left',
                valign: 'middle'
            },
            bodyStyles: {
                font: PDF_FONT_NAME,
                fontStyle: PDF_FONT_STYLE
            },
            alternateRowStyles: {
                fillColor: [245, 245, 245]
            },
            margin: {
                top: 28,
                right: 8,
                bottom: 10,
                left: 8
            },
            tableWidth: 'auto',
            didParseCell: function (data) {
                data.cell.styles.font = PDF_FONT_NAME;
            }
        });

        const filePrefix = config.filePrefix || 'raport';
        const fileName = filePrefix + '_' + getCurrentDateForFile() + '.pdf';
        doc.save(fileName);

        showPdfMessage('Raport PDF został wygenerowany.');
    }

    function isPdfFontAvailable(doc, fontName) {
        try {
            const fontList = doc.getFontList();
            return !!fontList && typeof fontList === 'object' && Object.prototype.hasOwnProperty.call(fontList, fontName);
        } catch (error) {
            console.error('Błąd sprawdzania fontu PDF:', error);
            return false;
        }
    }

    function normalizeValue(value, key) {
        if (value === null || value === undefined) {
            return '';
        }

        if (key === 'is_active') {
            if (String(value) === '1') return 'Tak';
            if (String(value) === '0') return 'Nie';
        }

        return String(value);
    }

    function getCurrentDateForFile() {
        const now = new Date();

        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day}_${hours}-${minutes}-${seconds}`;
    }

    function showPdfMessage(message) {
        pdfMessage.textContent = message;
        pdfMessage.classList.remove('d-none');
    }
});