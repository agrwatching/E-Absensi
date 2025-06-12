import sqlite3

# Ganti dengan path file kamu kalau tidak satu folder
db_path = 'absensidb.sqlite'

# Koneksi ke database
conn = sqlite3.connect(db_path)
cursor = conn.cursor()

# Ambil semua nama tabel
cursor.execute("SELECT name FROM sqlite_master WHERE type='table';")
tables = cursor.fetchall()

print("📋 Daftar Tabel di Database:")
for table in tables:
    print(f"- {table[0]}")

print("\n📂 Isi dan Struktur Tabel:\n")

# Loop ke tiap tabel
for table in tables:
    table_name = table[0]
    print(f"=== Tabel: {table_name} ===")

    # Lihat struktur kolom
    cursor.execute(f"PRAGMA table_info({table_name})")
    columns = cursor.fetchall()
    print("Kolom:")
    for col in columns:
        print(f"  - {col[1]} ({col[2]})")

    # Lihat isi tabel
    cursor.execute(f"SELECT * FROM {table_name}")
    rows = cursor.fetchall()

    if rows:
        print("\nIsi:")
        for row in rows:
            print(" ", row)
    else:
        print("\n(Tabel kosong)")

    print("\n" + "="*40 + "\n")

# Tutup koneksi
conn.close()
