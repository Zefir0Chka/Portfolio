using System;
using System.Collections.Generic;
using System.Drawing;
using System.IO;
using System.Windows.Forms;
using System.Linq;

namespace TodoApp
{
    public class TodoForm : Form
    {
        private ListBox taskList;
        private TextBox newTaskInput;
        private Button addButton;
        private Button deleteButton;
        private Button completeButton;
        private List<TodoItem> tasks;
        private const string SaveFileName = "tasks.txt";

        public TodoForm()
        {
            InitializeComponents();
            LoadTasks();
        }

        private void InitializeComponents()
        {
            this.Text = "Todo List";
            this.Size = new Size(600, 400);
            this.StartPosition = FormStartPosition.CenterScreen;

            newTaskInput = new TextBox
            {
                Location = new Point(10, 10),
                Size = new Size(400, 25)
            };

            addButton = new Button
            {
                Text = "Добавить",
                Location = new Point(420, 10),
                Size = new Size(80, 25)
            };
            addButton.Click += AddButton_Click;

            taskList = new ListBox
            {
                Location = new Point(10, 50),
                Size = new Size(400, 300),
                SelectionMode = SelectionMode.One
            };

            deleteButton = new Button
            {
                Text = "Удалить",
                Location = new Point(420, 50),
                Size = new Size(80, 25)
            };
            deleteButton.Click += DeleteButton_Click;

            completeButton = new Button
            {
                Text = "Выполнено",
                Location = new Point(420, 85),
                Size = new Size(80, 25)
            };
            completeButton.Click += CompleteButton_Click;

            this.Controls.Add(newTaskInput);
            this.Controls.Add(addButton);
            this.Controls.Add(taskList);
            this.Controls.Add(deleteButton);
            this.Controls.Add(completeButton);

            tasks = new List<TodoItem>();
        }

        private void AddButton_Click(object sender, EventArgs e)
        {
            if (!string.IsNullOrWhiteSpace(newTaskInput.Text))
            {
                var task = new TodoItem(newTaskInput.Text);
                tasks.Add(task);
                UpdateTaskList();
                newTaskInput.Clear();
                SaveTasks();
            }
        }

        private void DeleteButton_Click(object sender, EventArgs e)
        {
            if (taskList.SelectedIndex != -1)
            {
                tasks.RemoveAt(taskList.SelectedIndex);
                UpdateTaskList();
                SaveTasks();
            }
        }

        private void CompleteButton_Click(object sender, EventArgs e)
        {
            if (taskList.SelectedIndex != -1)
            {
                tasks[taskList.SelectedIndex].IsCompleted = true;
                UpdateTaskList();
                SaveTasks();
            }
        }

        private void UpdateTaskList()
        {
            taskList.Items.Clear();
            foreach (var task in tasks)
            {
                taskList.Items.Add(task.ToString());
            }
        }

        private void LoadTasks()
        {
            if (File.Exists(SaveFileName))
            {
                try
                {
                    string[] lines = File.ReadAllLines(SaveFileName);
                    tasks = lines.Select(line => TodoItem.FromString(line)).ToList();
                    UpdateTaskList();
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Ошибка при загрузке задач: {ex.Message}");
                }
            }
        }

        private void SaveTasks()
        {
            try
            {
                File.WriteAllLines(SaveFileName, tasks.Select(t => t.ToString()));
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Ошибка при сохранении задач: {ex.Message}");
            }
        }
    }

    public class TodoItem
    {
        public string Description { get; set; }
        public bool IsCompleted { get; set; }
        public DateTime CreatedAt { get; set; }

        public TodoItem(string description)
        {
            Description = description;
            IsCompleted = false;
            CreatedAt = DateTime.Now;
        }

        public override string ToString()
        {
            string status = IsCompleted ? "[✓]" : "[ ]";
            return $"{status} {Description}";
        }

        public static TodoItem FromString(string str)
        {
            var item = new TodoItem(str.Substring(4));
            item.IsCompleted = str.StartsWith("[✓]");
            return item;
        }
    }

    static class Program
    {
        [STAThread]
        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new TodoForm());
        }
    }
} 