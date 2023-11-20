import xmltodict
from subprocess import run
from flask import Flask, jsonify
app = Flask(__name__)

@app.route('/openports')
def openports_currentrange():
    """scan host"""

    run(['nmap', '--open', '-oX', 'scan.xml', '10.10.10.0/24'])

    with open('scan.xml') as raw_xml:
        nmap_scan = xmltodict.parse(raw_xml.read())

    # filter
    filtered_scan = {'hosts': []}

    for host in nmap_scan.get('nmaprun', {}).get('host', []):
        filtered_host = {
            'address': host.get('address', {}).get('@addr'),
            'hostnames': host.get('hostnames', {}).get('hostname', {}).get('@name') if host.get('hostnames') else None,
            'ports': []
        }

        # check if ports is a list before iterating
        if isinstance(host.get('ports', {}).get('port'), list):
            for port in host.get('ports', {}).get('port', []):
                filtered_port = {
                    'portid': port.get('@portid'),
                    'protocol': port.get('@protocol'),
                    'service': port.get('service', {}).get('@name'),
                    'state': port.get('state', {}).get('@state')
                }
                filtered_host['ports'].append(filtered_port)
        elif isinstance(host.get('ports', {}).get('port'), dict):
            # case where 'port' is dict
            port = host.get('ports', {}).get('port')
            filtered_port = {
                'portid': port.get('@portid'),
                'protocol': port.get('@protocol'),
                'service': port.get('service', {}).get('@name'),
                'state': port.get('state', {}).get('@state')
            }
            filtered_host['ports'].append(filtered_port)

        filtered_scan['hosts'].append(filtered_host)

    return jsonify(filtered_scan)
