from flask import Flask, request, jsonify, make_response
import pymysql

app = Flask(__name__)

@app.route('/')
@app.route('/index')
def index():
    return "Hello, World"

mydb = pymysql.connect(
    host="localhost",
    user="root",
    passwd="",
    database="db_rest"
)

@app.route('/products', methods=['POST'])
def web_command():
    hasil = {"status":"gagal"}
    query = "insert into products(id,name,price,quantity)values(%s,%s,%d,%d)"
    try:
        data = request.json
        id = data["id"]
        name = data["name"]
        price = data["price"]
        quantity = data["quantity"]
        value = (id, name, price, quantity)
        mycursor = mydb.cursor()
        mycursor.execute(query, value)
        mydb.commit()
        hasil = {"status":"berhasil"}
    except Exception as e:
        print("Error"+str(e))

    return jsonify(hasil)

@app.route('/get_data', methods=['GET'])
def web_sensor():
    query = "SELECT * FROM products"

    mycursor = mydb.cursor()
    mycursor.execute(query)
    row_headers = [x[0] for x in mycursor.description]
    data = mycursor.fetchall()
    json_data = []
    for result in data:
        json_data.append(dict(zip(row_headers, result)))
    mydb.commit()
    return make_response(jsonify(json_data),200)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5010)
