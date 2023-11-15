import xmltodict
from subprocess import run
from flask import Flask, jsonify
app = Flask(__name__)

@app.route('/openports')
def openports_currentrange():
    """scan host"""

    run(['nmap', '--open', '-oX', 'portscan.xml', '10.10.10.0/24'])

    with open('portscan.xml') as raw_xml:
        nmap_scan = xmltodict.parse(raw_xml.read())

    return jsonify(nmap_scan)

if __name__ == '__main__':
    app.run()
