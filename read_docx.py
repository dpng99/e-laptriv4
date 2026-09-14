import zipfile
import xml.etree.ElementTree as ET
import sys

def extract_text(path):
    try:
        doc = zipfile.ZipFile(path)
        xml_content = doc.read('word/document.xml')
        doc.close()
        tree = ET.XML(xml_content)
        NS = '{http://schemas.openxmlformats.org/wordprocessingml/2006/main}'
        paragraphs = []
        for p in tree.iter(NS + 'p'):
            texts = [node.text for node in p.iter(NS + 't') if node.text]
            if texts:
                paragraphs.append(''.join(texts))
            else:
                paragraphs.append('') # keep empty lines for structure
        return '\n'.join(paragraphs)
    except Exception as e:
        return str(e)

if __name__ == '__main__':
    with open('docx_output.txt', 'w', encoding='utf-8') as f:
        f.write(extract_text(sys.argv[1]))
