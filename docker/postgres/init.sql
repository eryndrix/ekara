DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_database WHERE datname = 'testdb'
    ) THEN
        CREATE DATABASE testdb;
    END IF;
END $$;
