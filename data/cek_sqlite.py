import sqlite3

# Lokasi database
db_path = "data/absensidb.sqlite"

# Koneksi ke database
conn = sqlite3.connect(db_path)
cursor = conn.cursor()

# Tampilkan semua tabel
print("📋 Daftar Tabel:")
cursor.execute("SELECT name FROM sqlite_master WHERE type='table'")
tabels = [row[0] for row in cursor.fetchall()]
for t in tabels:
    print(" -", t)

# Tampilkan foreign key dari tabel absensi
print("\n🔗 Foreign Key di tabel 'absensi':")
cursor.execute("PRAGMA foreign_key_list(absensi)")
fks = cursor.fetchall()
if fks:
    for fk in fks:
        print(f" - Kolom '{fk[3]}' → {fk[2]}({fk[4]}) [ON DELETE: {fk[6]}]")
else:
    print(" (tidak ada foreign key)")

# Tampilkan semua isi tabel siswa
print("\n👨‍🎓 Semua data siswa:")
cursor.execute("SELECT * FROM siswa")
rows = cursor.fetchall()
if rows:
    for row in rows:
        print(row)
else:
    print(" (tidak ada data siswa)")

# Tampilkan semua isi tabel absensi
print("\n📅 Semua data absensi:")
cursor.execute("SELECT * FROM absensi")
rows = cursor.fetchall()
if rows:
    for row in rows:
        print(row)
else:
    print(" (tidak ada data absensi)")

conn.close()
