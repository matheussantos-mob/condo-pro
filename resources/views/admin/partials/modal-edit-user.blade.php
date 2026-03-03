<div id="modalEditUser" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 overflow-hidden">
            <h3 class="text-xl font-black text-gray-800 mb-6 uppercase tracking-tighter">Editar Usuário</h3>

            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nome Completo</label>
                        <input type="text" name="name" id="edit_name" required class="w-full border-gray-200 rounded-xl focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">E-mail</label>
                        <input type="email" name="email" id="edit_email" required class="w-full border-gray-200 rounded-xl focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Função</label>
                        <select name="role" id="edit_role" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500">
                            <option value="porteiro">Porteiro</option>
                            <option value="sindico">Síndico</option>
                        </select>
                    </div>

                    <div class="p-4 bg-amber-50 rounded-xl border border-amber-100">
                        <label class="block text-xs font-bold text-amber-600 uppercase mb-1">Nova Senha (deixe em branco para manter)</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full border-amber-200 rounded-lg focus:ring-amber-500">
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition">Salvar Alterações</button>
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 text-gray-500 font-bold">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(user) {
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        
        const form = document.getElementById('editUserForm');
        form.action = `/admin/usuarios/${user.id}`;
        
        document.getElementById('modalEditUser').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modalEditUser').classList.add('hidden');
    }
</script>