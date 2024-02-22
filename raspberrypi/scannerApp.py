from flask import Flask, jsonify
import nmap

app = Flask(__name__)

def port_scan():
    nm = nmap.PortScanner()
    nm.scan(hosts='192.168.1.0/24') #todo make this ip not hardcoded
    results = []

    for host in nm.all_hosts():
        host_data = {
            'host': host,
            'hostname': nm[host].hostname(),
            'state': nm[host].state()
        }

        if 'tcp' in nm[host]:
            host_data['ports'] = list(nm[host]['tcp'].keys())
        else:
            host_data['ports'] = []

        results.append(host_data)

    return results

@app.route('/')
def index():
    return """
    <p>networkHub API :p</p>
    <a href="/scan">scan</a>
    """

@app.route('/scan')
def scan():
    try:
        scan_results = port_scan()
        return jsonify(scan_results)
    except Exception as err:
        return jsonify({'error': str(err)}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0') #makes available on local network
