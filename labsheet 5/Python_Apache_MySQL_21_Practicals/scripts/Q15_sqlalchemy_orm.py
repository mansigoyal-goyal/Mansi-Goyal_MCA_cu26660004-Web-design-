# Practical 15: SQLAlchemy ORM class-to-table mapping.
from sqlalchemy import create_engine, String, Integer
from sqlalchemy.orm import DeclarativeBase, Mapped, mapped_column, Session
from urllib.parse import quote_plus
from config import DB_CONFIG
pwd = quote_plus(DB_CONFIG["password"])
url = f"mysql+mysqlconnector://{DB_CONFIG['user']}:{pwd}@{DB_CONFIG['host']}:{DB_CONFIG['port']}/{DB_CONFIG['database']}"
engine = create_engine(url)
class Base(DeclarativeBase): pass
class User(Base):
    __tablename__ = "orm_users"
    user_id: Mapped[int] = mapped_column(Integer, primary_key=True, autoincrement=True)
    name: Mapped[str] = mapped_column(String(100))
    email: Mapped[str] = mapped_column(String(150), unique=True)
Base.metadata.create_all(engine)
with Session(engine) as session:
    if not session.query(User).filter_by(email="orm_demo@example.com").first():
        session.add(User(name="ORM Demo", email="orm_demo@example.com")); session.commit()
    for u in session.query(User).all(): print(u.user_id, u.name, u.email)
