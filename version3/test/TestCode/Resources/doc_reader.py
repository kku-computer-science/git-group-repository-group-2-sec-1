from docx import Document
import fitz 


def read_docx(file_path):
    """
    Reads text from a DOCX file and returns it as a single string.

    :param file_path: Path to the DOCX file
    :return: Extracted text from all paragraphs in the DOCX file
    """
    doc = Document(file_path)
    return "\n".join(p.text for p in doc.paragraphs)


def read_pdf(file_path):
    """
    Reads text from a PDF file using PyMuPDF (fitz) and returns it as a single.

    :param file_path: Path to the PDF file
    :return: Extracted text from all pages in the PDF file
    """
    doc = fitz.open(file_path)
    text = ""
    for page in doc:
        text += page.get_text("text")
    return text
