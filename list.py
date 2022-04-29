angka = [3,4,6,2,1,6,3,2,6,7]
print("="*5+"List"+"="*5)
print(angka)
print("="*14)
target = int(input("Masukan Nilai Target    :"))
for i in angka:
    b=target-i
    c=angka
    d=b in c
    if(d == True):
        print(f"[{angka.index(i)},{angka.index(b)}]")
        break
    else:
        print()