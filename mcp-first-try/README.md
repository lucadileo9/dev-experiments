# MCP First Try

![Python](https://img.shields.io/badge/Python-3776AB?style=flat&logo=python&logoColor=white)
![MCP](https://img.shields.io/badge/MCP-Protocol-orange)

First experiment with Model Context Protocol (MCP) - appointment management server.

## 🎯 Objective

Understand how Model Context Protocol works and create a functional MCP server:
- MCP client-server architecture
- Creating tools (executable functions)
- Resource and prompt management
- SQLite database integration
- JSON-RPC communication

## 🛠️ Tech Stack

- **Python 3.x** - Main language
- **MCP SDK** - Model Context Protocol SDK
- **SQLite** - Embedded database for calendars
- **JSON-RPC** - Communication protocol

## 💡 What I'm Learning

- Model Context Protocol specification
- MCP server architecture
- Tool definition and implementation
- State management and data persistence
- JSON-RPC communication
- Database design for simple applications
- Python async patterns (if applicable)

## 🔧 Implemented/Planned Features

### Available Tools

- **create_appointment** - Create new appointment
- **list_appointments** - List appointments (with filters)
- **update_appointment** - Update existing appointment
- **complete_appointment** - Mark appointment as completed
- **delete_appointment** - Delete appointment
- **search_appointments** - Search appointments by keyword

### Tool Parameters

Each tool accepts specific parameters (see implementation details in code):
- `title`, `description`, `priority` for creation
- `status`, `priority` for filters and updates
- `appointment_id` for specific operations
- `query` for search

## 🚀 Setup

### Prerequisites
- Python 3.8+
- pip

### Dependencies Installation

```bash
# Create virtual environment (recommended)
python -m venv venv

# Activate virtual environment
# Windows:
venv\Scripts\activate
# Linux/Mac:
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt
# or, if using pyproject.toml:
pip install -e .
```

### Start MCP Server

```bash
# Start server
python main.py

# Or, if configured differently:
python -m mcp_first_try
```

### Configuration

SQLite database is created automatically on first run.
See `DOCUMENTAZIONE_DATABASE.md` for complete database schema.

## 📁 Project Structure

```
mcp-first-try/
├── main.py                      # MCP server entry point
├── calendario_prenotazioni.py   # Calendar management logic
├── DOCUMENTAZIONE_DATABASE.md   # Database schema
├── pyproject.toml              # Project configuration
└── README.md                   # This file
```

## 🔌 Usage with MCP Client

```python
# Example tool call (pseudocode)
response = client.call_tool(
    "create_appointment",
    {
        "title": "Team meeting",
        "description": "Sprint planning discussion",
        "priority": "high"
    }
)
```
## 📝 Notes

This project is largey vibecoded, because it was for a one hour race for the most crative MCP project (XD)