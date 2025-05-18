DROP TABLE IF EXISTS tugas;

CREATE TABLE "tugas" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "deskripsi" TEXT NOT NULL,
  "waktu" INTEGER NOT NULL
);

INSERT INTO "tugas" ("deskripsi", "waktu") VALUES
('makan pagi', 60),
('kuliah', 360),
('latihan bulu tangkis', 60),
('olah raga', 150),
('jalan-jalan', 100),
('berenang', 60),
('tidur', 480);

