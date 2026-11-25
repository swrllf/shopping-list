# Конфигурация безопасности (config-check.md)

Команда: 3, проект: shopping-list, стек: Laravel

## 1. Секреты (.env)
- **.env в .gitignore:** Да. Файл добавлен в `.gitignore` (строка 2).
- **В репозитории только .env.example:** Да. `git ls-files | grep .env` показывает только `.env.example`.
- **История Git:** Проверена командой `git log --all --full-history -- .env`. Совпадений не найдено, секреты в историю не попадали.
![alt text](image-3.png)