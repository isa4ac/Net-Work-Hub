import json
import xmltodict
from subprocess import run
from flask import Flask, jsonify
app = Flask(__name__)

def parsePortData(port):
    result = []
    ports = port['port']

    for portData in ports:
        result.append(portData)

    return result

def parseHostData(hosts):
    results = []
    index = 0
    for host in hosts:
        result = dict()
        result['hostid'] = index
        result['address'] = host['address']
        result['hostnames'] = host['hostnames']
        result['ports'] = parsePortData(host['ports'])
        results.append(result)
        index += 1

    return results

def parseNmapData(data):
    result = dict()

    result['args'] = data['@args']
    result['startstr'] = data['@startstr']
    result['host'] = parseHostData(data['host'])
    result['runstats'] = data['runstats']

    return result

@app.route('/openports')
def openports_currentrange():
    """scan host"""

    run(['nmap', '--open', '-oX', 'portscan.xml', '10.10.10.0/24'])

    with open('portscan.xml') as raw_xml:
        nmap_scan = xmltodict.parse(raw_xml.read())
        print(jsonify(nmap_scan))

    return parseNmapData(json.loads(jsonify(nmap_scan)))

if __name__ == '__main__':
    app.run()
